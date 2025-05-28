function updateClock() {
    var now = new Date();
    var hours = now.getHours().toString().padStart(2, '0');
    var minutes = now.getMinutes().toString().padStart(2, '0');
    var seconds = now.getSeconds().toString().padStart(2, '0');
    var milisecconds = now.getMilliseconds().toString().padStart(3, '0');
    var timeString = hours + ':' + minutes + ':' + seconds ;
    document.getElementById('currentDateTime').textContent =  "เวลาปัจจุบัน : "+timeString;
}
setInterval(updateClock, 1000); // Update every second
updateClock(); // Update immediately

document.addEventListener('DOMContentLoaded', function() {
    var dateCells = document.querySelectorAll('.date-cell');
    dateCells.forEach(function(cell) {
        var dateString = cell.textContent.trim();
        var thaiDate = convertToThaiDate(dateString);
        cell.textContent = thaiDate;
    });
});

// function convertToThaiDate(dateString) {
//     var parts = dateString.split('-');
//     var year = parts[0];
//     var month = parseInt(parts[1]);
//     var day = parts[2];

//     var thaiMonths = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม',
//         'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
//     ];
//     var thaiMonth = thaiMonths[month - 1];

//     var thaiYear = parseInt(year) + 543;
//     var thaiDay = parseInt(day);
//     var thaiDateObject = new Date(thaiYear, month - 1, day);

//     // สร้างสตริงวันในสัปดาห์
//     var thaiDaysOfWeek = ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'];
//     var thaiDayOfWeek = thaiDaysOfWeek[thaiDateObject.getDay()];
//     var epic = document.getElementById('epic');
//     var space = document.createElement('p');
//     space.textContent = thaiDayOfWeek + 'ที่ ' + thaiDay + ' ' + thaiMonth + ' ' + thaiYear;
//     epic.appendChild(space); // เพิ่ม element space เข้าไปใน epic
//     return "ลงเวลาเข้า - ออกงานประจำวัน";
// }

function convertToThaiDate(dateString) {
    var parts = dateString.split('-');
    var year = parseInt(parts[0]);
    var month = parseInt(parts[1]);
    var day = parseInt(parts[2]);

    var thaiMonths = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม',
        'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
    var thaiMonth = thaiMonths[month - 1];

    var thaiYear = year + 543;
    var thaiDay = day;

    // ใช้ปี ค.ศ. สำหรับการคำนวณวันในสัปดาห์
    var dateObject = new Date(year, month - 1, day);
    var thaiDaysOfWeek = ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'];
    var thaiDayOfWeek = thaiDaysOfWeek[dateObject.getDay()];

    var epic = document.getElementById('epic');
    epic.textContent = thaiDayOfWeek + 'ที่ ' + thaiDay + ' ' + thaiMonth + ' ' + thaiYear;
    return "ลงเวลาเข้า - ออกงานประจำวัน";
}


document.addEventListener('DOMContentLoaded', () => {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((position) => {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;

            document.getElementById('latitude').value = latitude;
            document.getElementById('longitude').value = longitude;
            console.log("latitude : " + latitude);
            console.log("longitude : " + longitude);

        }, (error) => {
            console.error('เกิดข้อผิดพลาดในการเข้าถึงตำแหน่ง: ' + error.message);
        });
    } else {
        console.error('เบราว์เซอร์ไม่รองรับการเข้าถึงตำแหน่งปัจจุบัน');
    }
});

// datatables
window.addEventListener('DOMContentLoaded', event => {

    const datatablesSimple = document.getElementById('datatablesSimple');
    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple);
    }
});
