<template>
    <th :style="styleAttr">
        <a
            href="#"
            @click.prevent="sortBy()"
            v-bind:class="{ active: selected }"
            :title="title"
        >
            <slot></slot>
            <span class="arrow" v-bind:class="sortOrder > 0 ? 'asc' : 'dsc'">
            </span>
        </a>
    </th>
</template>

<script>
export default {
    name: "ss-grid-column-header",
    props: {
        params: {
            default: function() {}
        },
        selectedKey: [String, Number, Boolean],
        selectedOrder: {
            type: [String, Number, Boolean],
            default: '-1'
        },
        title: [String, Number],
        styleAttr: [String]
    },
    mounted: function () {
        if (this.params.sortField == this.selectedKey) {
            this.sortOrder = this.selectedOrder < 0 ? '-1' : '1';
        }
    },
    data: function() {
        return {
            sortOrder: this.params.InitialSortOrder
        };
    },

    computed: {
        selected: function() {
            return this.params.sortField === this.selectedKey;
        }
    },
    methods: {
        sortBy: function() {
            if (this.sortOrder == "asc") {
                this.sortOrder = -1;
            } else {
                this.sortOrder = this.sortOrder == 1 ? -1 : 1;
            }
            this.getData();
        },

        getData: function(new_page_number) {
            this.$emit("selectedSort", {
                sortField: this.params.sortField,
                sortOrder: this.sortOrder
            });
        }
    }
};
</script>

<style scoped></style>
