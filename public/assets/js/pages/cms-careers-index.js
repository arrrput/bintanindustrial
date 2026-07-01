    // Native vector-based PDF generation using jsPDF & jspdf-autotable
    function downloadPDF(monthName, tableId) {
        const BIE_GREEN = [25, 135, 84]; // BIIE Green: #198754
        const BIE_GREEN_DARK = [15, 81, 50]; // Darker BIIE Green: #0f5132
        const tableEl = document.getElementById(tableId);
        if (!tableEl) return;
        
        // Retrieve BIE Logo from DOM
        const logoImgEl = document.querySelector('.logo img') || document.querySelector('header img') || document.querySelector('.branding img');
        let logoBase64 = null;
        if (logoImgEl && logoImgEl.complete) {
            try {
                const canvas = document.createElement("canvas");
                canvas.width = logoImgEl.naturalWidth || logoImgEl.width || 120;
                canvas.height = logoImgEl.naturalHeight || logoImgEl.height || 120;
                const ctx = canvas.getContext("2d");
                ctx.drawImage(logoImgEl, 0, 0, canvas.width, canvas.height);
                logoBase64 = canvas.toDataURL("image/png");
            } catch (e) {
                console.error("Failed to convert logo to base64: ", e);
            }
        }
        
        const rows = tableEl.querySelectorAll('tbody tr');
        const tableData = [];
        let counter = 1;
        
        rows.forEach(row => {
            const tds = row.querySelectorAll('td');
            // Skip non-data rows
            if (tds.length < 5) return;
            
            const h6El = tds[0].querySelector('h6');
            const dateEl = tds[0].querySelector('span.text-muted');
            
            if (!h6El) return;
            
            const title = h6El.innerText.trim();
            const dateText = dateEl ? dateEl.innerText.replace('Created:', '').trim() : '';
            const closeDateText = tds[1] ? tds[1].innerText.trim() : '-';
            const applicants = tds[2] ? tds[2].innerText.trim() : '0';
            const hired = tds[3] ? tds[3].innerText.trim() : '0';
            
            tableData.push([
                counter++,
                title,
                dateText,
                closeDateText,
                applicants,
                hired
            ]);
        });
        
        // Calculate Totals
        const totalVacancies = tableData.length;
        let totalApplicants = 0;
        let totalHired = 0;
        
        tableData.forEach(row => {
            totalApplicants += parseInt(row[4]) || 0;
            totalHired += parseInt(row[5]) || 0;
        });
        
        // If empty, add placeholder
        if (tableData.length === 0) {
            tableData.push(['-', 'No closed vacancies found for this period.', '', '', '', '']);
        }
        
        // Initialize native jsPDF
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        
        // Add BIE Logo & Header text (Native vector text, not image!)
        let textXOffset = 14;
        if (logoBase64) {
            try {
                const imgWidth = logoImgEl.naturalWidth || logoImgEl.width || 120;
                const imgHeight = logoImgEl.naturalHeight || logoImgEl.height || 120;
                const aspectRatio = imgWidth / imgHeight;
                
                const pdfImgHeight = 11; // 11mm height for logo
                const pdfImgWidth = pdfImgHeight * aspectRatio;
                
                doc.addImage(logoBase64, 'PNG', 14, 11, pdfImgWidth, pdfImgHeight);
                textXOffset = 14 + pdfImgWidth + 4; // Dynamic padding
                
                doc.setFont("helvetica", "bold");
                doc.setFontSize(18);
                doc.setTextColor(BIE_GREEN_DARK[0], BIE_GREEN_DARK[1], BIE_GREEN_DARK[2]);
                doc.text("BINTAN INDUSTRIAL ESTATE", textXOffset, 19);
                
                doc.setFont("helvetica", "normal");
                doc.setFontSize(10);
                doc.setTextColor(108, 117, 125);
                doc.text("CMS Recruitment Portal - Vacancies History Report", textXOffset, 25);
            } catch (imgErr) {
                console.error("Error adding image to PDF: ", imgErr);
                doc.setFont("helvetica", "bold");
                doc.setFontSize(18);
                doc.setTextColor(BIE_GREEN_DARK[0], BIE_GREEN_DARK[1], BIE_GREEN_DARK[2]);
                doc.text("BINTAN INDUSTRIAL ESTATE", 14, 20);
                
                doc.setFont("helvetica", "normal");
                doc.setFontSize(10);
                doc.setTextColor(108, 117, 125);
                doc.text("CMS Recruitment Portal - Vacancies History Report", 14, 26);
            }
        } else {
            doc.setFont("helvetica", "bold");
            doc.setFontSize(18);
            doc.setTextColor(BIE_GREEN_DARK[0], BIE_GREEN_DARK[1], BIE_GREEN_DARK[2]);
            doc.text("BINTAN INDUSTRIAL ESTATE", 14, 20);
            
            doc.setFont("helvetica", "normal");
            doc.setFontSize(10);
            doc.setTextColor(108, 117, 125);
            doc.text("CMS Recruitment Portal - Vacancies History Report", 14, 26);
        }
        
        // Divider line
        doc.setDrawColor(BIE_GREEN_DARK[0], BIE_GREEN_DARK[1], BIE_GREEN_DARK[2]);
        doc.setLineWidth(0.5);
        doc.line(14, 30, 196, 30);
        
        // Report details
        doc.setFont("helvetica", "bold");
        doc.setFontSize(11);
        doc.setTextColor(33, 37, 41);
        doc.text(`Month Group: ${monthName.toUpperCase()}`, 14, 38);
        
        doc.setFont("helvetica", "normal");
        doc.setFontSize(9);
        doc.setTextColor(140, 152, 165);
        const generatedDate = new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
        doc.text("Generated: " + generatedDate, 196 - doc.getTextWidth("Generated: " + generatedDate), 38);
        
        // Generate table using jspdf-autotable
        doc.autoTable({
            startY: 42,
            head: [['No', 'Job Title', 'Created Date', 'Close Date', 'Applicants', 'Hired']],
            body: tableData,
            theme: 'striped',
            headStyles: {
                fillColor: BIE_GREEN, // Restore green header background
                textColor: [255, 255, 255], // White text
                fontSize: 10,
                fontStyle: 'bold'
            },
            bodyStyles: {
                fontSize: 9,
                textColor: [33, 37, 41]
            },
            columnStyles: {
                0: { halign: 'center', cellWidth: 12 },
                1: { fontStyle: 'bold', cellWidth: 'auto' },
                2: { halign: 'center', cellWidth: 30 }, // Created Date
                3: { halign: 'center', cellWidth: 30 }, // Close Date
                4: { halign: 'center', fontStyle: 'bold', textColor: [13, 110, 253], cellWidth: 22 }, // Blue text for applicants
                5: { halign: 'center', fontStyle: 'bold', textColor: BIE_GREEN, cellWidth: 22 } // Green text for hired
            },
            didParseCell: function (data) {
                if (data.section === 'head') {
                    if (data.column.index === 0 || data.column.index === 2 || data.column.index === 3 || data.column.index === 4 || data.column.index === 5) {
                        data.cell.styles.halign = 'center';
                    } else {
                        data.cell.styles.halign = 'left';
                    }
                }
            },
            margin: { left: 14, right: 14 }
        });
        
        // Summary block (Table layout matching above)
        const finalY = doc.lastAutoTable.finalY || 100;
        
        // Title Summary styled like Month Group title
        doc.setFont("helvetica", "bold");
        doc.setFontSize(11);
        doc.setTextColor(33, 37, 41);
        doc.text("SUMMARY REPORT", 14, finalY + 15);
        
        // Generate summary table using jspdf-autotable
        doc.autoTable({
            startY: finalY + 20,
            head: [['Total Vacancies', 'Total Applicants', 'Total Hired']],
            body: [[totalVacancies, totalApplicants, totalHired]],
            theme: 'striped',
            headStyles: {
                fillColor: BIE_GREEN, // Restore green header background
                textColor: [255, 255, 255], // White text
                fontSize: 10,
                fontStyle: 'bold',
                halign: 'center'
            },
            bodyStyles: {
                fontSize: 10,
                textColor: [33, 37, 41],
                halign: 'center',
                fontStyle: 'bold'
            },
            columnStyles: {
                0: { halign: 'center', cellWidth: 60 },
                1: { halign: 'center', cellWidth: 60 },
                2: { halign: 'center', cellWidth: 62 }
            },
            margin: { left: 14, right: 14 }
        });
        
        // Footer text
        const pageCount = doc.internal.getNumberOfPages();
        for (let i = 1; i <= pageCount; i++) {
            doc.setPage(i);
            doc.setFontSize(8);
            doc.setTextColor(173, 181, 189);
            doc.text(`Page ${i} of ${pageCount}`, 14, 287);
            doc.text(`© ${new Date().getFullYear()} Bintan Industrial Estate. Confidential HR Document.`, 196 - doc.getTextWidth(`© ${new Date().getFullYear()} Bintan Industrial Estate. Confidential HR Document.`), 287);
        }
        
        // Save PDF natively!
        doc.save(`vacancies-history-${monthName.toLowerCase().replace(' ', '-')}.pdf`);
    }

    document.addEventListener("DOMContentLoaded", function() {
        const toast = document.getElementById('adminSuccessToast');
        if (toast) {
            setTimeout(() => { toast.classList.add('show'); }, 100);
            setTimeout(() => { toast.classList.remove('show'); }, 3000);
        }

        const monthSelect = document.getElementById('monthFilterSelect');
        if (monthSelect) {
            monthSelect.addEventListener('change', function() {
                const selectedVal = this.value;
                const accordionItems = document.querySelectorAll('#accordionHistory .accordion-item');
                
                accordionItems.forEach(item => {
                    const slugId = item.getAttribute('data-month-slug');
                    const collapseDiv = item.querySelector('.accordion-collapse');
                    const btn = item.querySelector('.accordion-button');
                    
                    if (selectedVal === 'all') {
                        item.style.display = 'block';
                        // Collapse all
                        collapseDiv.classList.remove('show');
                        btn.classList.add('collapsed');
                        btn.setAttribute('aria-expanded', 'false');
                    } else {
                        if (slugId === selectedVal) {
                            item.style.display = 'block';
                            // Expand
                            collapseDiv.classList.add('show');
                            btn.classList.remove('collapsed');
                            btn.setAttribute('aria-expanded', 'true');
                        } else {
                            item.style.display = 'none';
                            // Collapse
                            collapseDiv.classList.remove('show');
                            btn.classList.add('collapsed');
                            btn.setAttribute('aria-expanded', 'false');
                        }
                    }
                });
            });
        }
    });
