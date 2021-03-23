import {Controller} from 'stimulus';

export default class extends Controller {
    connect() {
        const $button = this.element;
        const $container = document.querySelector('.tricks-container[data-url]');

        let total = $container.getAttribute('data-total');
        let loaded = 15;
        let count = 0;

        if (total <= loaded) {
            $button.remove();
        } else {
            $button.addEventListener('click', () => {
                $button.classList.add('disabled');
                count++;

                loaded += 15;

                if (total <= loaded) {
                    $button.remove();
                }

                fetch($container.getAttribute('data-url') + "/" + count).then(resp => {
                    return resp.text();
                }).then(html => {
                    $container.innerHTML += html;
                    $button.classList.remove('disabled');
                })
            });
        }
    }
}