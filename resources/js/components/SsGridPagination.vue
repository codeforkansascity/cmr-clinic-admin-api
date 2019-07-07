<template>
    <div>
        <div class="btn-group pagination justify-content-start justify-content-lg-center" role="group"
             aria-label="Pagination button group">
            <a
                    href="#"
                    @click.prevent="gotoPage(first_page_number)"
                    class="btn btn-outline-secondary mb-2"
                    title="First"
                    v-bind:class="{disabled: isCurrentPageFirst}">
                first
            </a>
            <a
                    href="#"
                    @click.prevent="gotoPage(prev_page_number)"
                    class="btn btn-outline-secondary mb-2"
                    title="Previous"
                    v-bind:class="{disabled: isCurrentPageFirst}">
                prev
            </a>
            <template
                    v-for="page in pages"
                    v-if="page > current_page - 2 && page < current_page + 2">
                <a
                        href="#"
                        @click.prevent="gotoPage(page)"
                        v-bind:class="{
                                'btn mb-2': true,
                                'btn-secondary active': isCurrentPage(page),
                                'btn-outline-secondary': !isCurrentPage(page)
                            }"
                        v-bind:title="'Page ' + page">
                    {{ page }}
                </a>
            </template>
            <a
                    href="#"
                    @click.prevent="gotoPage(next_page_number)"
                    class="btn btn-outline-secondary mb-2"
                    title="Next"
                    v-bind:class="{disabled: isCurrentPageLast}">
                next
            </a>
            <a
                    href="#"
                    @click.prevent="gotoPage(last_page)"
                    class="btn btn-outline-secondary mb-2"
                    title="Last"
                    v-bind:class="{disabled: isCurrentPageLast}">
                last
            </a>
        </div>
    </div>
</template>

<script>

    export default {

        name: 'ss-grid-pagination',

        props: {
            current_page: [String, Number],
            last_page: [String, Number],
            total: [String, Number],
        },

        data: function () {

            return {
                pages: [],
                first_page_number: 1,
            }
        },

        watch: {
            current_page: function () {
                this.resetPageNumbers();
            },
            last_page: function () {
                this.resetPageNumbers();
            },
            total: function () {
                this.resetPageNumbers();
            },
        },

        computed: {
            next_page_number() {
                return this.current_page < this.last_page ? this.current_page + 1 : null;
            },
            prev_page_number() {
                return this.current_page > 2 ? this.current_page - 1 : null;
            },
            isCurrentPageFirst() {
                return this.current_page == 1;
            },
            isCurrentPageLast() {
                return this.current_page == this.last_page;
            }
        },

        methods: {

            resetPageNumbers: function () {

                this.pages = [];

                for (var i = 1; i <= this.last_page; i++) {
                    this.pages.push(i);
                }

            },

            gotoPage: function (page) {
                this.$emit('goto-page', page);
            },

            isCurrentPage: function (page) {
                return page == this.current_page;
            },

            checkUrlNotNull: function (url) {
                return url != null;
            },

            pageInRange: function () {
                return this.go_to_page <= parseInt(this.last_page);
            },

        }
    }

</script>
