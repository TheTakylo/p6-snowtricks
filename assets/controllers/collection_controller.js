import {Controller} from 'stimulus';

export default class extends Controller {

    $collection;
    $container;
    collection_prototype;

    connect() {
        this.$collection = this.element;

        const $collection_add = this.$collection.parentElement.parentElement.querySelector('.collection-add');

        const $container = document.createElement('div');
        $container.classList.add('row');

        this.$collection.append($container);

        this.$container = $container;

        this.collection_prototype = "<button type='button' class='btn btn-danger btn-sm collection-remove' data-id='__name__'>X</button>" + this.element.dataset['prototype'];

        this.counter = 0;

        this.addPrototype();

        $collection_add.addEventListener('click', () => {
            this.addPrototype();
        })
    }

    addPrototype() {
        let $div = document.createElement('div');
        $div.classList.add('col-md-3');

        this.counter++;

        $div.innerHTML = this.collection_prototype
            .replaceAll('__name__label__', 'Image')
            .replaceAll('__name__', this.counter);

        this.$container.append($div);

        $div.querySelector('button.collection-remove').addEventListener('click', () => {
            $div.remove();
        });
    }
}