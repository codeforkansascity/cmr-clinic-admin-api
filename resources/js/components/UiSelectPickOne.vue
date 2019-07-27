/*
<ui-select-pick-one
        url="/api-vc-discipline/options"
        v-model="form_data.discipline_id"
        :selected_id="form_data.discipline_id ">
</ui-select-pick-one>

</ui-select-pick-one>

*/
<template>
    <select
            v-on:input="updateValue($event.target.value)"
            class="grid-filter"
            v-model="initval"
    >
        <option v-for="c in optionsList" v-bind:value="c.value">
            {{ c.text }}
        </option
        >
    </select>
</template>

<script>
    export default {
        name: "ui-select-pick-one",

        props: {
            url: [String, Number],
            selected_id: [String, Number]
        },

        mounted: function () {
            this.getOptions();
            this.initval = this.selected_id;
        },

        data: function () {
            return {
                optionsList: [],
                initval: null
            };
        },

        methods: {
            updateValue: function (value) {
                this.$emit("input", value);
            },

            getOptions: function () {
                var self = this;

                // Get cycles data from API
                var url = this.url;
                $.getJSON(
                    url,
                    function (data) {
                        // Clear list
                        self.optionsList = [];

                        var keys = Object.keys(data);
                        for (var i = 0; i < keys.length; i++) {
                            self.optionsList.push({
                                text: data[i].name,
                                value: data[i].id
                            });
                        }
                    }.bind(this)
                );
            }
        }
    };
</script>
