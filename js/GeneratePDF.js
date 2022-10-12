window.onload = function () {
  document.getElementById("generate-PDF").addEventListener("click", () => {
    //const para = this.document.getElementsByClassName("para")[0].removeAttribute("style");

    const invoice = this.document.getElementById("toPrint");
    var opt = {
      margin: 0.5,
      filename: "ContratK2.pdf",
      image: {
        type: "JPG",
        quality: 0.98
      },
      html2canvas: {
        scale: 2
      },
      //jump to next page : choise css class of the element to be jumped next
      // pagebreak: { mode: 'avoid-all', before: '#next' },
      // pagebreak: { mode: 'avoid-all', before: '.para' },
      pagebreak: {
        after: "#para",
        after: ["#next", "#para"]
      },
      jsPDF: {
        unit: "in",
        format: "letter",
        orientation: "portrait"
      },
    };
    html2pdf()
      .from(invoice)
      .set(opt)
      .toPdf()
      .get("pdf")
      .then(function (pdf) {
        var totalPages = pdf.internal.getNumberOfPages();
        var footer =
          "k2 Group SAS au capital de 40000.00 euro - RC DIJON:4669B";
        for (i = 1; i <= totalPages - 1; i++) {
          pdf.setPage(i);
          pdf.setFontSize(7);
          pdf.setTextColor(0);
          pdf.text(
            "" + i + "/" + totalPages,
            pdf.internal.pageSize.getWidth() / 1.1,
            pdf.internal.pageSize.getHeight() - 0.3
          );
          pdf.text(
            footer,
            pdf.internal.pageSize.getWidth() / 3.118,
            pdf.internal.pageSize.getHeight() - 0.4
          );
          pdf.text(
            "7 RUE JEAN BAPTISTE SAY 21800 CHEVIGNY ST SAUVEUR",
            pdf.internal.pageSize.getWidth() / 3.14,
            pdf.internal.pageSize.getHeight() - 0.3
          );
          pdf.text(
            "Siret: 88236307000013 TVA: FR59882363090 APE: 4669B",
            pdf.internal.pageSize.getWidth() / 3.02,
            pdf.internal.pageSize.getHeight() - 0.2
          );
        }
      })
      .save();
  });
};