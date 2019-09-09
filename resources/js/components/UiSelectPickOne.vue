/*
<ui-select-pick-one
        url="/api-vc-discipline/options"
        v-model="form_data.discipline_id"
        name="discipline_id"
        :selected_id="form_data.discipline_id ">
</ui-select-pick-one>

*/
<template>
    <select
            v-on:input="updateValue($event.target.value)"
            :class="'form-control ' + this.additional_classes"
            v-model="initval"
            :name="this.name"
            :id="'field_' + this.name"
            :style="this.styleAttr"
    >
        <option v-bind:value="this.blank_value">{{ this.blank_text }}</option>
        <option v-for="c in optionsList" v-bind:value="c.value">
            {{ c.text }}
        </option>
        <optgroup v-for="optionGroup in optionGroupsList" :label="optionGroup.label">
            <option v-for="c in optionGroup.options" :value="c.value">
                {{c.text}}
            </option>
        </optgroup>
    </select>
</template>

<script>
    export default {
        name: "ui-select-pick-one",

        props: {
            url: [String, Number],
            selected_id: [String, Number, Array],
            name: {
                type: String,
                default: ''
            },
            blank_text: {
                type: String,
                default: '- Select -'
            },
            blank_value: {
                type: [String, Number],
                default: ''
            },
            additional_classes: {
                type: String,
                default: ''
            },
            styleAttr: {
                type: String,
                default: ''
            },
        },

        mounted: function() {
            this.getOptions();
        },

        data: function() {
            return {
                optionsList: [],
                optionGroupsList: [],
                initval: null
            };
        },

        methods: {
            updateValue: function(value) {
                this.$emit("input", value);
            },

            getOptions: function() {
                var self = this;

                // Get cycles data from API
                var url = this.url;
                $.getJSON(
                    url,
                    function(data) {
                        // Clear lists
                        self.optionsList = [];
                        self.optionGroupsList = [];

                        if( data[0] && data[0].optgroup) {
                            // Returned values are grouped in optgroups
                            var keys = Object.keys(data);
                            for (var i = 0; i < keys.length; i++) {
                                var options = [];
                                var keys2 = Object.keys(data[i].options);
                                for (var j = 0; j < keys2.length; j++) {
                                    options.push({
                                        'text': data[i].options[j].name,
                                        'value': data[i].options[j].id
                                    });
                                }
                                self.optionGroupsList.push({
                                    label: data[i].name,
                                    options: options
                                });
                            }
                        } else {
                            // Returned values are a straight list of options
                            var keys = Object.keys(data);
                            for (var i = 0; i < keys.length; i++) {
                                self.optionsList.push({
                                    text: data[i].name,
                                    value: data[i].id
                                });
                            }
                        }

                        // Set value after data comes back
                        this.initval = this.selected_id;
                    }.bind(this)
                );
            }
        }
    };
</script>
