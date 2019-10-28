/*
<ui-pick-roles
    url="/api-user/role-options"
    v-model="form_data.selected_roles"
    :selected_roles="roles"
    name="user">
</ui-pick-roles>

*/
<template>
    <div>
        <div class="indented-block checkbox-item" v-for="c in optionsList" v-bind:key="c.value">
            <input type="checkbox"
                   :id="'checkbox_value_' + c.value"
                   :value="c.value"
                   @change="updateValue"
                   v-model="checkedRoles">
            <label v-bind:for="'checkbox_value_' + c.value">{{c.text}}</label>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ui-pick-roles",
        model: {
            prop: 'selected_roles',
            event: 'change'
        },

        props: {
            url: [String, Number],
            selected_roles: [String, Number, Array],

            additional_classes: {
                type: String,
                default: ''
            },
            styleAttr: {
                type: String,
                default: ''
            },
        },

        mounted: function () {
            this.getOptions();
            this.checkedRoles = this.selected_roles;
        },

        data: function () {
            return {
                optionsList: [],
                optionGroupsList: [],
                checkedRoles: []
            };
        },

        methods: {
            updateValue: function (value) {
                this.$emit("change", this.checkedRoles);
            },

            getOptions: function () {
                var self = this;

                // Get cycles data from API
                var url = this.url;
                $.getJSON(
                    url,
                    function (data) {
                        // Clear lists
                        self.optionsList = [];
                        self.optionGroupsList = [];

                        if (data[0] && data[0].optgroup) {
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
                        this.selected = this.selected_id;
                    }.bind(this)
                );
            }
        }
    };
</script>
