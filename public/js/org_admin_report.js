//datatable
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

// // อ็อบเจกต์เพื่อแปลงเดือนจากอังกฤษเป็นภาษาไทย
// const monthTranslations = {
//     'January': 'มกราคม',
//     'February': 'กุมภาพันธ์',
//     'March': 'มีนาคม',
//     'April': 'เมษายน',
//     'May': 'พฤษภาคม',
//     'June': 'มิถุนายน',
//     'July': 'กรกฎาคม',
//     'August': 'สิงหาคม',
//     'September': 'กันยายน',
//     'October': 'ตุลาคม',
//     'November': 'พฤศจิกายน',
//     'December': 'ธันวาคม'
// };

// // ฟังก์ชันแสดงเดือนปัจจุบันในภาษาไทย
// function displayCurrentMonth() {
//     const currentMonthEnglish = document.getElementById('currentMonth').innerText; // อ่านค่าเดือนปัจจุบันจากอีเลเมนต์ที่มี ID ว่า currentMonth
//     const currentMonthThai = monthTranslations[currentMonthEnglish]; // แปลงเป็นภาษาไทย
//     document.getElementById('currentMonth').innerText = currentMonthThai; // อัพเดตเนื้อหาของอีเลเมนต์ให้เป็นภาษาไทย
// }

// เรียกใช้ฟังก์ชันเมื่อหน้าเว็บโหลด
// document.addEventListener('DOMContentLoaded', displayCurrentMonth);
// อ็อบเจกต์เพื่อแปลงเดือนจากอังกฤษเป็นภาษาไทย

const monthTranslations = {
    'January': 'มกราคม',
    'February': 'กุมภาพันธ์',
    'March': 'มีนาคม',
    'April': 'เมษายน',
    'May': 'พฤษภาคม',
    'June': 'มิถุนายน',
    'July': 'กรกฎาคม',
    'August': 'สิงหาคม',
    'September': 'กันยายน',
    'October': 'ตุลาคม',
    'November': 'พฤศจิกายน',
    'December': 'ธันวาคม'
};

// ฟังก์ชันแสดงเดือนและปีปัจจุบันในภาษาไทย
function displayCurrentMonthAndYear() {
    const currentMonthEnglish = document.getElementById('currentMonth').innerText; // อ่านค่าเดือนปัจจุบันจากอีเลเมนต์ที่มี ID ว่า currentMonth
    const currentMonthThai = monthTranslations[currentMonthEnglish]; // แปลงเป็นภาษาไทย
    document.getElementById('currentMonth').innerText = currentMonthThai; // อัพเดตเนื้อหาของอีเลเมนต์ให้เป็นภาษาไทย

    const currentYear = new Date().getFullYear(); // รับปีปัจจุบัน
    const thaiYear = currentYear + 543; // แปลงเป็นปีไทย
    document.getElementById('currentYear').innerText = thaiYear; // แสดงปีไทย
}

// เรียกใช้ฟังก์ชันเมื่อหน้าเว็บโหลด
document.addEventListener('DOMContentLoaded', displayCurrentMonthAndYear);

