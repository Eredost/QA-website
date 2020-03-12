const searchFormClassName = 'search__form';
const searchIconClassName = 'search__icon';
const searchInputClassName = 'q';

export default class Header {
    constructor(headerClassName) {
        this.header = document.querySelector(`.${headerClassName}`);
        this.searchFormElement = document.querySelector(`.${searchIconClassName} + .${searchFormClassName}`);
        this.searchInputElement = document.querySelector(`.${this.header.className} input[name="${searchInputClassName}"]`);

        let searchIconElement = document.querySelector(`.${this.header.className} .${searchIconClassName}`);

        searchIconElement.addEventListener('click', this.handleSearchIconClick.bind(this));
        this.searchInputElement.addEventListener('blur', this.handleSearchInputBlur.bind(this));
    }

    handleSearchInputBlur() {
        this.searchFormElement.classList.add('hidden');
    }

    handleSearchIconClick(event) {
        this.searchFormElement.classList.remove('hidden');
        this.searchInputElement.focus();
    }
}
