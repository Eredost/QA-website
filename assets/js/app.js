/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import ('../scss/app.scss');

class Header {
    constructor(headerSelector) {
        this.header = document.querySelector(headerSelector);

        let searchDivElement = document.querySelector(`.${this.header.className} .profile__search`);
        searchDivElement.addEventListener('mouseover', this.handleSearchFormMouseOver);
        searchDivElement.addEventListener('mouseleave', this.handleSearchFormMouseLeave);
    }

    handleSearchFormMouseOver(event) {
        document.querySelector(`.${event.currentTarget.className} .search__form`).classList.remove('hidden');
    }

    handleSearchFormMouseLeave(event) {
        document.querySelector(`.${event.currentTarget.className} .search__form`).classList.add('hidden');
    }
}

window.addEventListener('DOMContentLoaded', () => {
    new Header('.header');
});
