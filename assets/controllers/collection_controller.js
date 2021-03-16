import {Controller} from 'stimulus';

export default class extends Controller {

    counter = 0;
    id;
    prototype;

    addButton;

    connect() {
        this.prototype = this.element.getAttribute('data-prototype');
        this.id = this.element.getAttribute('id');

        this.addButton = document.querySelector("#" + this.id + "_collection_add");

        if (this.watchOld() === false) {
            this.addPrototype();
        }

        this.addButton.addEventListener('click', () => {
            this.addPrototype();
        })
    }

    addPrototype() {
        this.counter++;

        let $div = document.createElement('div');

        $div.innerHTML = this.prototype
            .replaceAll('__name__label__', '')
            .replaceAll('__name__', this.counter) + this.getDeleteButtonHTML();

        $div.querySelector('legend.col-form-label').remove();

        this.element.append($div);

        $div.querySelector('button.collection-delete').addEventListener('click', () => {
            $div.remove();
        })
    }

    watchOld() {
        let result = false;

        this.element.querySelectorAll('fieldset.form-group').forEach(i => {
            i.querySelector('legend.col-form-label').remove();

            let $div = document.createElement('div');
            $div.innerHTML = this.getDeleteButtonHTML();

            $div.addEventListener('click', () => {
                $div.parentElement.remove();
            })

            i.append($div);

            result = true;
        });

        return result;
    }

    getDeleteButtonHTML() {
        return "<button type='button' class='mt-1 collection-delete btn btn-sm btn-danger'>Supprimer</button>";
    }
}