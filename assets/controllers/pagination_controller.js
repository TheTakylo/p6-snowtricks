import {Controller} from 'stimulus';

export default class extends Controller {

    currentPage;
    $commentsAjax;

    connect() {
        const $prev = this.element.querySelector('.pagination-prev');
        const $next = this.element.querySelector('.pagination-next');
        const $paginationItems = this.element.querySelectorAll(".pagination-item");

        this.$commentsAjax = document.querySelector('div#comments div#comments-ajax');

        const params = new URLSearchParams(window.location.search);

        this.currentPage = Number(params.get('page')) ?? 1;

        $prev.addEventListener('click', (e) => {
            e.preventDefault();
            this.currentPage--;
            this.loadComments();
        });

        $next.addEventListener('click', (e) => {
            e.preventDefault();
            this.currentPage++;
            this.loadComments();
        });

        $paginationItems.forEach(item => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                this.currentPage = Number(item.querySelector('a').innerText);
                this.loadComments();
            });
        })
    }

    loadComments() {
        fetch(this.element.getAttribute('data-url') + "?page=" + this.currentPage).then(resp => {
            return resp.text();
        }).then(html => {
            this.$commentsAjax.innerHTML = html;

            let currentUrlParams = new URLSearchParams(window.location.search);
            currentUrlParams.set('page', this.currentPage);
            window.history.pushState({}, '', window.location.pathname + "?" + currentUrlParams.toString() + "#comments");
        })
    }
}