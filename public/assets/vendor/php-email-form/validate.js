/**
* PHP Email Form Validation - v3.9
* URL: https://bootstrapmade.com/php-email-form/
* Author: BootstrapMade.com
*/
(function () {
  "use strict";

  let forms = document.querySelectorAll('.php-email-form');

  forms.forEach( function(e) {
    e.addEventListener('submit', function(event) {
      event.preventDefault();

      let thisForm = this;

      let action = thisForm.getAttribute('action');
      let recaptcha = thisForm.getAttribute('data-recaptcha-site-key');
      
      if( ! action ) {
        displayError(thisForm, 'The form action property is not set!');
        return;
      }
      if (thisForm.dataset.submitting === '1') return; // already sending
      thisForm.dataset.submitting = '1';
      ButtonLoading.start(ButtonLoading.submitButtonOf(thisForm, event.submitter), 'Sending...');

      let formData = new FormData( thisForm );

      if ( recaptcha ) {
        if(typeof grecaptcha !== "undefined" ) {
          grecaptcha.ready(function() {
            try {
              grecaptcha.execute(recaptcha, {action: 'php_email_form_submit'})
              .then(token => {
                formData.set('recaptcha-response', token);
                php_email_form_submit(thisForm, action, formData);
              })
            } catch(error) {
              displayError(thisForm, error);
            }
          });
        } else {
          displayError(thisForm, 'The reCaptcha javascript API url is not loaded!')
        }
      } else {
        php_email_form_submit(thisForm, action, formData);
      }
    });
  });

  function php_email_form_submit(thisForm, action, formData) {
    fetch(action, {
      method: 'POST',
      body: formData,
      headers: {'X-Requested-With': 'XMLHttpRequest'}
    })
    .then(response => {
      if( response.ok ) {
        return response.text();
      } else {
        // Laravel validation (JSON) or plain-text error responses
        return response.text().then(text => {
          let message = text;
          try {
            const json = JSON.parse(text);
            message = json.errors ? Object.values(json.errors).flat().join('<br>') : (json.message || text);
          } catch (e) {}
          throw new Error(message || `${response.status} ${response.statusText}`);
        });
      }
    })
    .then(data => {
      finishSubmit(thisForm);
      if (data.trim() == 'OK') {
        AppAlert.success('Your message has been sent. Thank you!');
        thisForm.reset();
        if (typeof grecaptcha !== 'undefined' && grecaptcha.reset) grecaptcha.reset();
      } else {
        throw new Error(data ? data : 'Form submission failed and no error message returned from: ' + action); 
      }
    })
    .catch((error) => {
      displayError(thisForm, error);
    });
  }

  function finishSubmit(thisForm) {
    delete thisForm.dataset.submitting;
    thisForm.querySelectorAll('[data-loading="1"]').forEach(btn => ButtonLoading.stop(btn));
  }

  function displayError(thisForm, error) {
    finishSubmit(thisForm);
    AppAlert.error(error && error.message ? error.message : String(error));
  }

})();
