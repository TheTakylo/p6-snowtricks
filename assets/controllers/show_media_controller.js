import {Controller} from 'stimulus';

export default class extends Controller {
    connect() {

        const $carouselContainer = document.querySelector('#trick-show');

        this.element.addEventListener('click', () => {
            $carouselContainer.classList.remove('d-none');

            this.element.classList.add('d-none');
        })
    }
}