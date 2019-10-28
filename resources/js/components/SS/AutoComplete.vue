/*
Example usage;
<autocomplete
    url="/statutes/all"
    create
    v-model="charge.citation"
    valueField="number"
    displayField="name"
    @selected="statuteSelected"
></autocomplete>

Props:
list: an array can be used for data if this is used the url field will be ignored
url: string of the url to get the data from this is used once when loaded to get the entire list
create: Optional this option allows the create button to appear if the data doesn't exist in the list
valueField: Optional if the data is not a string this field is needed to determine the value field
displayField: Optional if an additional field is used for displaying a list
displayLimit: this will limit the number of character shown for the display field on the drop down list default is 50

Events:
input: when input is changed the value is returned to keep in sync with parent
selected: this is fired when an item is selected from the list and will return the entire object
create: if the create option is used this will return the value of the input field
*/

<template>
    <div class="dropdown" id="dropdown" style="position: relative;" >
        <input class="form-control"
               type="text"
               :value="value"
               @click="toggleDropdown"
               @input="updateValue($event.target.value)"
               @keydown.enter.prevent = 'enter'
               @keydown.down = 'down'
               @keydown.up = 'up'
               @keydown.esc="toggleDropdown"
               :disabled="disabled"
               @blur="handleBlur"
        >
        <ul class="search-box dropdown-content" v-if="open" >
            <li v-for="(result, index) in matches"
                v-bind:class="{'active': isActive(index), 'selected-result': current === index}"
                class="search-result"
                @click="resultClick(index)"
            >
                <span class="form-control-label search-label"
                      v-html="getListing(result)"
                >
                </span>
            </li>
            <li v-if="create">
                <button class="text-center active btn btn default search-result w-100" @click.prevent="addNew">
                    Add New
                </button>
            </li>
        </ul>

    </div>

</template>

<script>
    import BaseModal from "./BaseModal";

    export default {
        components: {BaseModal},
        props: {

            value: {
                // type: String,
                required: true
            },

            list: {
                type: Array,
                default: () => []
            },

            valueField: {
                // object property to use as value
                type: String,
                required: false,
                default: 'number'
            },
            displayField: {
                // optional field is added to the label
                type: String,
                required: false
            },
            displayLimit: {
                type: Number,
                default: 1000
            },
            maxResults: {
                type: Number,
                default: 50,
            },
            url: {
                type: String,
                required: false
            },
            create: {
                type: Boolean|Function,
                required: false
            },
            disabled: {
                type: Boolean,
                default: false,
            },
            searchableFields: {
                type: String,
                default: ''
            }

        },

        data () {
            return {
                open: false,
                current: 0,
                data: [],
                modal_fields: [],
            }
        },

        computed: {
            // Filtering the result based on the input
            matches () {
                let matches = this.data.filter((obj) => {
                    if(this.searchableFields) {
                        let match = false
                        let searchFields = this.searchableFields.split(',')
                        for(let field in searchFields) {
                            console.log(obj[ searchFields[field]] )
                            match = obj[searchFields[field]].toLowerCase().indexOf(this.value.toLowerCase()) >= 0 ? true: match
                        }
                        return match
                    } else {
                        return this.getValue(obj).indexOf(this.value) >= 0

                    }
                })
                if(matches.length > this.maxResults) {
                    matches.length = this.maxResults
                }

                return matches
            },

            openResult () {
                return this.selection !== '' &&
                    this.matches.length !== 0 &&
                    this.open === true
            }
        },
        created() {
            this.getData()
        },
        mounted() {

        },
        methods: {

            updateValue (value) {
                if (this.open === false) {
                    this.open = true
                    this.current = 0
                }
                this.$emit('input', value)
            },

            // When enter pressed on the input
            enter () {
                let i = this.current
                this.$emit('selected', this.matches[i])
                this.updateValue(this.getValue(this.matches[i]))

                this.open = false
            },

            // When up pressed while results are open
            up () {
                if (this.current > 0) {
                    this.current--
                }
            },

            // When up pressed while results are open
            down () {
                if (this.current < this.matches.length - 1) {
                    this.current++
                }
            },

            // For highlighting element
            isActive (index) {
                return index === this.current
            },

            resultClick (index) {
                console.log('resultClick')
                this.$emit('input', this.getValue(this.matches[index]))
                this.$emit('selected', this.matches[index])
                this.open = false
            },

            getValue(row) {
                if(this.valueField) {
                    return row[this.valueField]
                }
                return row
            },
            getDisplay(row) {
                if(this.displayField) {
                    let display = row[this.displayField]
                    if(display.length > this.displayLimit) {
                        display = display.substr(0, this.displayLimit) + ' ...'
                    }
                    return display
                }
                return null
            },
            getListing(row) {
                let display = this.getValue(row)
                if(this.displayField) {
                    display += ` <small>${this.getDisplay(row)}</small>`
                }
                return display
            },
            getData() {

                if(this.list.length > 0) {
                    this.data = this.list
                    return
                }
                let $this = this
                axios.get(this.url)
                    .then(res => {
                        if(res.data) {
                            $this.data = res.data
                        }
                    })
                    .catch(e => {console.error(e)})
            },
            toggleDropdown()
            {
                this.open = !this.open
            },

            addNew() {
                this.open = false
                this.$emit('create', this.value)

            },
            closeDropdown() {
                this.open = false
            },
            handleBlur(e) {
                this.$emit('blur', e,)
                if(e.target.parentElement.id !== 'dropdown') {
                    this.closeDropdown()
                }
            }
        }

    }
</script>

<style scoped>

    ul, li {list-style-type: none;}

    .search-result {
        width: 100%;
        white-space: nowrap;
        padding-bottom: 3px;
        padding-left: 5px;
    }
    .search-result:hover {
        color: white;
        background: var(--primary, #4dc0b5);

    }
    .selected-result {
        color: white;
        background: var(--primary, #4dc0b5);
    }
    .search-box {
        max-height: 25vh;
        overflow: auto;
        border-radius: 5px;
        padding-right: 1em;
    }

    /* The container <div> - needed to position the dropdown content */
    .dropdown {
        position: relative;
        display: inline-block;

    }

    /* Dropdown Content (Hidden by Default) */
    .dropdown-content {
        padding-left: 0;
        position: absolute;
        background-color: white;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }


    /* Change color of dropdown links on hover */
    .dropdown-content a:hover {background-color: #ddd}

</style>
