
const menuItems = document.querySelectorAll('.menu-item');

const messagesNotes = document.querySelector('#messages-notification');
const messages = document.querySelector('.messages');
const message = messages.querySelectorAll('.message');
const messageSearch = document.querySelector('#messages-search');

const theme = document.querySelector('#theme')
const themeModal = document.querySelector('.customize-theme')
const fontSizes = document.querySelectorAll('.choose-size span')

var root = document.querySelector(':root');
var body = document.querySelector('body');

var colorLine = document.querySelector('.color .color-line');
var color = colorLine.querySelector('input')

var bgGroup = document.querySelector('.background .choose-bg')
var bg = bgGroup.querySelectorAll('div');
 


const removeActive = (arr, clas = 'active') =>{
    arr.forEach(i =>{

        i.classList.remove(clas);
    })
}

/* Menu items logic*/
menuItems.forEach(i => {

    i.addEventListener('click', ()=>{

        removeActive(menuItems);
        i.classList.add('active');

        if(i.id != 'notification'){ // Notification count logic
            document.querySelector('.notifications-popup').style.display = 'none';
        }else{
            document.querySelector('.notifications-popup').style.display = 'block';
            document.querySelector('#notification .notification-count').style.display = 'none';

        }
    })
});


var searchMessage = () =>{ // checks if search bar matches message sender
    const val = messageSearch.value.toLowerCase();

    message.forEach(c => {
        let name = c.querySelector('h5').textContent.toLowerCase();
        if(name.indexOf(val) != -1){

            c.style.display = 'flex';
        }else{
            c.style.display = 'none';
        }
    })
}


//search chats
messageSearch.addEventListener('keyup', searchMessage);


// Message count logic
messagesNotes.addEventListener('click', ()=>{

    messages.style.boxShadow = '0 0 1rem var(--color-primary)';
    messagesNotes.querySelector('.notification-count').style.display = 'none';
    messageSearch.focus();
    setTimeout(() => {
    messages.style.boxShadow = 'none';
    }, 2000);
});

//Theme customiztion

const openModal = () =>{
    themeModal.style.display = 'grid';
}
const closeThemeModal = (e) =>{
    if(e.target.classList.contains('customize-theme')){

        themeModal.style.display = 'none';
        removeActive(menuItems);
        menuItems[0].classList.add('active');
    }

}

themeModal.addEventListener('click', closeThemeModal);
theme.addEventListener('click', openModal);


fontSizes.forEach(s =>{ 

    s.addEventListener('click', () =>{

        removeActive(fontSizes)
        let fontSize;
        s.classList.toggle('active');

        if (s.classList.contains('font-size-1')){

            fontSize = '10px';
            root.style.setProperty('--sticky-top-left', '5.4rem');
            root.style.setProperty('--sticky-top-right', '5.4rem');

        }else if (s.classList.contains('font-size-2')){

            fontSize = '13px';
            root.style.setProperty('--sticky-top-left', '5.4rem');
            root.style.setProperty('--sticky-top-right', '-7rem');

        }else if (s.classList.contains('font-size-3')){

            fontSize = '16px';
            root.style.setProperty('--sticky-top-left', '-2rem');
            root.style.setProperty('--sticky-top-right', '-17rem');

        }else if (s.classList.contains('font-size-4')){

            fontSize = '19px';
            root.style.setProperty('--sticky-top-left', '-5rem');
            root.style.setProperty('--sticky-top-right', '-25rem');

        }else if (s.classList.contains('font-size-5')){

            fontSize = '22px';
            root.style.setProperty('--sticky-top-left', '-12rem')
            root.style.setProperty('--sticky-top-right', '-35rem')

        }
        document.querySelector('html').style.fontSize = fontSize;    

    })
})

colorLine.addEventListener('click', ()=> {

    root.style.setProperty('--hue', `${color.value}`)
})

bg.forEach(l =>{

  
    l.addEventListener('click', () =>{

        removeActive(bg)
        l.classList.toggle('active');
        

        if (l.classList.contains('bg-l')){

            root.style.setProperty( '--color-white', 'white');
            root.style.setProperty('--color-dark', 'hsl(var(--hue), 30%, 17%)');
            root.style.setProperty('--color-light', 'hsl(var(--hue), 30%, 95%)');
            body.style.setProperty('color', 'black');

        }else if (l.classList.contains('bg-d')){

            root.style.setProperty( '--color-white','hsl(var(--hue), 30%, 40%)');
            root.style.setProperty('--color-dark', 'hsl(var(--hue), 30%, 15%)');
            root.style.setProperty('--color-light', 'hsl(var(--hue), 30%, 20%)');
            body.style.setProperty('color', 'white');
        

        }else if (l.classList.contains('bg-b')){

            root.style.setProperty( '--color-white','hsl(var(--hue), 30%, 7%)');
            root.style.setProperty('--color-dark', 'hsl(var(--hue), 30%, 0%)');
            root.style.setProperty('--color-light', 'hsl(var(--hue), 30%, 0%)');
            body.style.setProperty('color', 'white');

        }
    })
})