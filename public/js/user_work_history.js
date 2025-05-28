// $(document).ready(function() {

//     var table = $('#data-table').DataTable({
//         language: {
//             url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/th.json',
//         },
//         "paging": false,
//         "info": false,
//         "ordering": false,
//         "dom":"lrtip",
//     });


//     $('#month-filter').on('change', function() {
//         var selectedMonth = $(this).val();
//         if (selectedMonth === "none") {
//             table.columns(4).search('').draw();
//         } else {
//             table.columns(4).search(selectedMonth).draw();
//         }
//     });
// });

// document.addEventListener('DOMContentLoaded', function() {
//     var dateCells = document.querySelectorAll('.date-cell');
//     dateCells.forEach(function(cell) {
//         var dateString = cell.textContent.trim();
//         var thaiDate = convertToThaiDate(dateString);
//         cell.textContent = thaiDate;
//     });
// });

function convertToThaiDate(dateString) {
    var parts = dateString.split('-');
    var year = parts[0];
    var month = parseInt(parts[1]);
    var day = parts[2];

    var thaiMonths = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม',
        'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
    ];
    var thaiMonth = thaiMonths[month - 1];

    var thaiYear = parseInt(year) + 543;
    var thaiDay = parseInt(day);
    var thaiDateObject = new Date(thaiYear, month - 1, day);

    // สร้างสตริงวันในสัปดาห์
    var thaiDaysOfWeek = ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'];
    var thaiDayOfWeek = thaiDaysOfWeek[thaiDateObject.getDay()];
    return "วัน" + thaiDayOfWeek + ' ' + thaiDay + ' ' + thaiMonth + ' ' + thaiYear  ;
}

function isWeekend(day) {
    return day === 0 || day === 6;
}

function isThaiHoliday(date) {
    var thaiHolidays = ["01-01", "04-06", "04-13", "04-14", "04-15", "05-01", "05-05", "05-19", "07-01", "07-26", "10-23"];

    var formattedDate = ('0' + (date.getMonth() + 1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2);

    return thaiHolidays.includes(formattedDate);
}

function changeMonth(selectedMonth) {
    var monthNames = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
    var currentYear = new Date().getFullYear();

    var month = parseInt(selectedMonth) || new Date().getMonth() + 1; // ถ้าไม่มีค่าเดือนที่เลือกให้ใช้เดือนปัจจุบัน
    var currentDate = new Date(currentYear, month - 1);
    var daysInMonth = new Date(currentYear, month, 0).getDate();
    var count = 0;

    for (var i = 1; i <= daysInMonth; i++) {
        var currentDate = new Date(currentYear, month - 1, i);
        var dayOfWeek = currentDate.getDay();
        
        if (!isWeekend(dayOfWeek) && !isThaiHoliday(currentDate)) {
            count++;
        }
    }

    document.querySelector('.dayinmonth').innerHTML = "มีวันทำงานทั้งหมดมี " + count + " วัน ในเดือน"+ monthNames[month - 1];
}

