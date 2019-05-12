let app = new Vue({
    el: '.main-container',
    data:{
        rooms: [],
        show: [],
        getRoomsUrl: '',
        roomSelected: false,
        roomId: null
    },
    methods:{
        selectRoom(id) {
            this.roomSelected = true;
            this.roomId = id;
            this.updateRoomDevices();
        },
        unselectRoom(){
          this.roomSelected = false;
          this.roomId = null;
          this.show = [];
        },
        updateRoomDevices(){
            if(!this.roomSelected)
                return;

            this.show = this.rooms.filter(r => r.id == this.roomId)[0].devices;
        },
        setRooms(rooms){
            this.rooms = rooms;
        },
        changeValue(item){
            let id = item.id;
            let value = item.value;
            let onof = ['on', 'off'];
            let openclose = ['open', 'close'];

            if(onof.includes(value))
                value = onof.filter(i=> i != value)[0];

            if(openclose.includes(value))
                value = openclose.filter(i=> i != value)[0];

            item.value = value;

            fetch(`/api/device/${id}/${value}`).then(r=>{
                this.update();
            });
        },
        startUpdating(){
            setInterval(()=>this.update(), 10000);
        },
        update(){
            fetch(this.getRoomsUrl)
                .then(r=>r.json())
                .then(j=>{
                    this.setRooms(j);
                    this.updateRoomDevices();
                });
        }
    }
});

class RoomSlider{
    constructor(slider){
        this.current = 0;
        this.offset = 0;
        this.opened = false;
        this.init(slider);
        this.initTouchEvents();
    }

    init(slider){
        this.slider = slider;
        this.wrapper = slider.firstElementChild;
        this.count = this.wrapper.childElementCount;
        this.slides = this.wrapper.children;

        this.wrapper.addEventListener('click', e=>{
                this.open();
        });
    }

    initTouchEvents(){
        this.wrapper.addEventListener('touchstart', e=>{
            if(this.move || this.opened)
                return;

            this.setTouch(e.changedTouches[0]);
            this.move = true;
            this.wrapper.style.transition = 'none';
        });

        this.wrapper.addEventListener('touchend', e=>{
            if(e.changedTouches[0].identifier != this.touchId  || this.opened)
                return;

            this.move = false;
            this.wrapper.style.transition = null;

            let offset = this.touchOffset ? Math.round(this.touchOffset / 90) : 0;
            this.current += offset;
            this.draw();
            this.touchOffset = 0;
        });

        this.wrapper.addEventListener('touchmove', e=>{
            if(this.opened)
                return;

            let touch = e.changedTouches[0];
            if(this.move && touch.identifier == this.touchId){
                let x = touch.clientX;
                let screenWidth = window.innerWidth;
                let offset = Math.floor(x / screenWidth * 100);
                offset = this.startOffset - offset;
                this.touchOffset = offset;
                this.setTranslate(this.getOffset() + offset);
            }
        });

        window.addEventListener('backbutton', e=>{
            if(!this.opened)
                return;

            e.preventDefault();
            this.close();
        });
    }

    getCurrent(){
        return this.slides[this.current];
    }

    setTouch(touch){
        this.move = true;
        this.touchId = touch.identifier;
        this.startOffset = Math.floor(touch.clientX / window.innerWidth * 100)
    }

    setOffset(offset){
        this.offset = offset;
    }

    next(){
        this.current++;
        this.draw();
    }

    prew(){
        this.current--;
        this.draw();
    }

    draw(){
        this.checkLimit();
        let offset = this.getOffset();
        this.setTranslate(offset);
    }

    getOffset(){
        let offset = 90 * this.current;

        if(!this.opened)
            offset -= this.offset;

        return offset;
    }

    checkLimit(){
        let currentItem = this.current + 1;
        this.current = currentItem > this.count ? this.count - 1 : this.current;
        this.current = this.current < 0 ? 0 : this.current;
    }

    setTranslate(offset){
        this.wrapper.style.transform = `translateX(${-offset}vw)`;
    }

    open(){
        this.opened = true;
        this.draw();
        this.getCurrent().classList.add('open');
        this.slider.classList.add('open');
        setTimeout(()=>this.getCurrent().firstElementChild.classList.add('open'), 350);

        let image = this.getCurrent().firstElementChild.children[1];
        window.addEventListener('scroll', e=>this.imageParalax(e));

        app.selectRoom(this.getCurrent().dataset.roomId);
    }

    close(){
        this.opened = false;
        this.draw();
        this.getCurrent().classList.remove('open');
        this.getCurrent().firstElementChild.classList.remove('open');
        this.slider.lastElementChild.style.display = 'none';
        setTimeout(()=>{
            this.slider.classList.remove('open');
            this.slider.lastElementChild.style.display = null;
        }, 350);
        this.getCurrent().firstElementChild.children[1].style.backgroundPosition = null;
        app.unselectRoom();
    }

    imageParalax(e, image){
        if(!this.opened)
            return;

        let y = window.scrollY;
        this.getCurrent().firstElementChild.children[1].style.backgroundPosition = `0 ${y}px`;
    }
}

let slider = new RoomSlider(room_slider)
slider.setOffset(5);
slider.draw();