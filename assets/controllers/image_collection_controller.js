import {Controller} from 'stimulus';

export default class extends Controller {

    $collection;
    $collection_add_container;
    $collection_add;
    prototype;

    connect() {
        this.prototype = this.element.dataset['prototype'];

        this.$collection = this.element;
        this.$collection.classList.add('row');

        this.$collection_add_container = this.$collection.parentElement.parentElement.querySelector('.collection-add-container');
        this.$collection_add = this.$collection_add_container.querySelector('button.collection-add');

        this.$collection.append(this.$collection_add_container);

        const $existingElements = this.$collection.querySelectorAll('fieldset.form-group');

        this.counter = $existingElements.length + 1;

        $existingElements.forEach(i => i.classList.add('col-md-4'));

        this.$collection.querySelectorAll('legend.col-form-label').forEach(i => i.innerText = "");

        this.$collection_add.addEventListener('click', () => {
            this.addPrototype();

            this.$collection.querySelector('fieldset.form-group.col-md-3:last-of-type input[type="file"]').click();
        });
    }

    addPrototype() {
        this.counter++;

        let $div = document.createElement('div');
        $div.innerHTML = this.prototype
            .replaceAll('__name__label__', '')
            .replaceAll('__name__', this.counter);

        $div = $div.firstChild
        $div.classList.add('col-md-3');

        this.$collection.insertBefore($div, this.$collection_add_container);

        $div.querySelector('button.collection-remove').addEventListener('click', () => {
            $div.remove();
        });

        $div.querySelector('input').addEventListener('change', (e) => {
            let _div = document.querySelector('#trick_images_' + this.counter + '_file').parentElement.parentElement;
            _div.querySelector('img').src = URL.createObjectURL(e.target.files[0]);
        });
    }
}