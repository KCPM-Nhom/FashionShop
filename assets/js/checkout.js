/**
 * Xử lý sự kiện tại trang Thanh toán
 */
document.addEventListener('DOMContentLoaded', function () {
    const addressSelector = document.getElementById('address_selector');
    const inputFullname = document.getElementById('fullname');
    const inputPhone = document.getElementById('phone');
    const inputAddress = document.getElementById('address');

    // 1. Lắng nghe sự kiện thay đổi khi chọn địa chỉ có sẵn
    if (addressSelector) {
        addressSelector.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];

            if (this.value !== "") {
                // Lấy dữ liệu từ các thuộc tính data-*
                const name = selectedOption.getAttribute('data-name');
                const phone = selectedOption.getAttribute('data-phone');
                const details = selectedOption.getAttribute('data-details');

                // Điền vào các ô input
                inputFullname.value = name;
                inputPhone.value = phone;
                inputAddress.value = details;

                // Hiệu ứng nhẹ để người dùng biết dữ liệu đã thay đổi
                highlightInput([inputFullname, inputPhone, inputAddress]);
            } else {
                // Nếu chọn "Sử dụng địa chỉ mới", xóa trắng các ô
                inputFullname.value = "";
                inputPhone.value = "";
                inputAddress.value = "";
                inputFullname.focus();
            }
        });
    }

    // Hàm tạo hiệu ứng highlight khi dữ liệu tự động điền
    function highlightInput(elements) {
        elements.forEach(el => {
            el.style.backgroundColor = "#e8f0fe";
            setTimeout(() => {
                el.style.backgroundColor = "";
            }, 500);
        });
    }
});