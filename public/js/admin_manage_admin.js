window.addEventListener('DOMContentLoaded', event => {
    const datatablesSimple = document.getElementById('datatablesSimple');
    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple, {
            labels: {
                placeholder: "ค้นหา ...",
                perPage: "รายการต่อหน้า",
                noRows: "ไม่พบข้อมูล",
                info: "แสดง {start} ถึง {end} จาก {rows} รายการ"
            }
        });
    }
});
