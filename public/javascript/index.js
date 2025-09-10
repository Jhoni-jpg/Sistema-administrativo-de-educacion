const checkValidation = () => {
    const checkbox = document.querySelector('#inputCheckbox-id');
    const contentInfor = document.querySelector('.divCaptcha_sectionInfo');

    checkbox.addEventListener('change', () => {
        if (checkbox.checked) {
            contentInfor.classList.remove('animationContainer-uncheck');
            contentInfor.classList.add('animationContainer-check');
            contentInfor.style.display = 'flex';
        } else {
            contentInfor.classList.remove('animationContainer-check');
            contentInfor.classList.add('animationContainer-uncheck');
            
            setTimeout(() => {
                contentInfor.style.display = 'none';
            }, 300);
        }
    });
}

checkValidation();