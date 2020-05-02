const searchFormClassName = 'search__form';
const searchIconClassName = 'search__icon';
const searchInputName = 'q';
const profileClassName = 'profile__registered';
const profileMenuClassName = 'profile__menu';

export default class Header {
    constructor(headerClassName) {
        this.header = document.querySelector(`.${headerClassName}`);
        this.searchFormElement = document.querySelector(`.${searchIconClassName} + .${searchFormClassName}`);
        this.searchInputElement = document.querySelector(`.${this.header.className} input[name="${searchInputName}"]`);

        this.profileElement = document.querySelector(`.${this.header.className} .${profileClassName}`);
        this.profileMenuElement = this.profileElement.querySelector(`.${profileMenuClassName}`);

        let searchIconElement = document.querySelector(`.${this.header.className} .${searchIconClassName}`);

        searchIconElement.addEventListener('click', this.handleSearchIconClick.bind(this));
        this.searchInputElement.addEventListener('blur', this.handleSearchInputBlur.bind(this));

        this.profileElement.addEventListener('mouseover', this.handleProfileMouseOver.bind(this));
        this.profileElement.addEventListener('mouseout', this.handleProfileMouseOut.bind(this));
    }

    handleSearchInputBlur() {
        this.searchFormElement.classList.add('hidden');
    }

    handleSearchIconClick(event) {
        this.searchFormElement.classList.remove('hidden');
        this.searchInputElement.focus();
    }

    handleProfileMouseOver() {
        this.profileMenuElement.classList.remove('hidden');
    }

    handleProfileMouseOut() {
        this.profileMenuElement.classList.add('hidden');
    }
}
