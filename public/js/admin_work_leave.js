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

$(document).ready(function () {
    $('.form-select').select2({
        width: '100%' // ตั้งค่าความกว้าง
    });
});

function convertToThaiDate(dateString) {
    var parts = dateString.split('-');
    var year = parseInt(parts[0]);
    var month = parseInt(parts[1]);
    var day = parseInt(parts[2]);

    var thaiMonths = [
        'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
        'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
    ];
    var thaiMonth = thaiMonths[month - 1];

    var thaiYear = year + 543;

    var dateObject = new Date(year, month - 1, day);
    var thaiDaysOfWeek = ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'];
    var thaiDayOfWeek = thaiDaysOfWeek[dateObject.getDay()];

    return "วัน" + thaiDayOfWeek + ' ' + day + ' ' + thaiMonth + ' ' + thaiYear;
}

document.addEventListener("DOMContentLoaded", function () {
    var dateCells = document.querySelectorAll(".date-cell");

    dateCells.forEach(function (cell) {
        var date = cell.textContent.trim();
        var thaiDate = convertToThaiDate(date);
        cell.textContent = thaiDate;
    });
});
