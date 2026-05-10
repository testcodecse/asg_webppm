document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');
    if(contactForm) {
        contactForm.addEventListener('submit', function(e) {
            let valid = true;
            
            const name = document.getElementById('name');
            const email = document.getElementById('email');
            const phone = document.getElementById('phone');
            const message = document.getElementById('message');
            
            if(!name.value.trim()) {
                document.getElementById('nameError').innerText = 'Vui lòng nhập họ tên';
                valid = false;
            } else {
                document.getElementById('nameError').innerText = '';
            }
            
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if(!email.value.trim()) {
                document.getElementById('emailError').innerText = 'Vui lòng nhập email';
                valid = false;
            } else if(!emailPattern.test(email.value)) {
                document.getElementById('emailError').innerText = 'Email không hợp lệ';
                valid = false;
            } else {
                document.getElementById('emailError').innerText = '';
            }
            
            if(phone.value && !/^[0-9]{10,11}$/.test(phone.value)) {
                document.getElementById('phoneError').innerText = 'Số điện thoại không hợp lệ (10-11 số)';
                valid = false;
            } else {
                document.getElementById('phoneError').innerText = '';
            }
            
            if(!message.value.trim()) {
                document.getElementById('messageError').innerText = 'Vui lòng nhập nội dung';
                valid = false;
            } else {
                document.getElementById('messageError').innerText = '';
            }
            
            if(!valid) e.preventDefault();
        });
    }
    
    const loginForm = document.getElementById('loginForm');
    if(loginForm) {
        loginForm.addEventListener('submit', function(e) {
            let valid = true;
            const username = document.getElementById('username');
            const password = document.getElementById('password');
            
            if(!username.value.trim()) {
                document.getElementById('usernameError').innerText = 'Vui lòng nhập tên đăng nhập';
                valid = false;
            } else {
                document.getElementById('usernameError').innerText = '';
            }
            
            if(!password.value) {
                document.getElementById('passwordError').innerText = 'Vui lòng nhập mật khẩu';
                valid = false;
            } else {
                document.getElementById('passwordError').innerText = '';
            }
            
            if(!valid) e.preventDefault();
        });
    }
    
    const registerForm = document.getElementById('registerForm');
    if(registerForm) {
        registerForm.addEventListener('submit', function(e) {
            let valid = true;
            const username = document.getElementById('reg_username');
            const email = document.getElementById('reg_email');
            const password = document.getElementById('reg_password');
            const confirm = document.getElementById('confirm_password');
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if(!username.value.trim()) {
                document.getElementById('reg_usernameError').innerText = 'Vui lòng nhập tên đăng nhập';
                valid = false;
            } else if(username.value.length < 3) {
                document.getElementById('reg_usernameError').innerText = 'Tên đăng nhập ít nhất 3 ký tự';
                valid = false;
            } else {
                document.getElementById('reg_usernameError').innerText = '';
            }
            
            if(!email.value.trim()) {
                document.getElementById('reg_emailError').innerText = 'Vui lòng nhập email';
                valid = false;
            } else if(!emailPattern.test(email.value)) {
                document.getElementById('reg_emailError').innerText = 'Email không hợp lệ';
                valid = false;
            } else {
                document.getElementById('reg_emailError').innerText = '';
            }
            
            if(!password.value) {
                document.getElementById('reg_passwordError').innerText = 'Vui lòng nhập mật khẩu';
                valid = false;
            } else if(password.value.length < 6) {
                document.getElementById('reg_passwordError').innerText = 'Mật khẩu ít nhất 6 ký tự';
                valid = false;
            } else {
                document.getElementById('reg_passwordError').innerText = '';
            }
            
            if(password.value !== confirm.value) {
                document.getElementById('confirm_passwordError').innerText = 'Mật khẩu xác nhận không khớp';
                valid = false;
            } else {
                document.getElementById('confirm_passwordError').innerText = '';
            }
            
            if(!valid) e.preventDefault();
        });
    }
});