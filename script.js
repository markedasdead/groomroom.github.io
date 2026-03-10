const btnLogin = document.getElementById('loginBtn');
const btnRegister = document.getElementById('registerBtn');
const btnLogo = document.querySelector('.header__title');

const pages = {
    main: document.getElementById('main'),
    login: document.getElementById('login'),
    register: document.getElementById('register')
};

function changePage(targetKey) {
    const current = document.querySelector('main.active');
    const target = pages[targetKey];

    if (current === target) return; 

    if (current) {
        current.classList.remove('active');
        current.classList.add('exit-up');
        
        setTimeout(() => {
            current.classList.remove('exit-up');
        }, 600);
    }

    target.classList.add('active');
}

btnLogin.onclick = () => changePage('login');
btnRegister.onclick = () => changePage('register');
btnLogo.onclick = () => changePage('main');