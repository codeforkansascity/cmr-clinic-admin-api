<template>
    <div class="dropdown" style="position: relative;">
        <input class="form-control" :aria-expanded="openResult"
               id="dropdownMenu2" data-toggle="dropdown"
               type="text" :value="value" @input="updateValue($event.target.value)"
               @keydown.enter = 'enter'
               @keydown.down = 'down'
               @keydown.up = 'up'
        >
        <ul class="dropdown-menu search-box" aria-labelledby="dropdownMenu2">
            <li v-for="(result, index) in matches"
                v-bind:class="{'active': isActive(index)}"
                class="search-result w-100"
                @click="resultClick(index)"
            >
                <span class="form-control-label search-label"
                    :class="{'selected-result': current === index}"
                      v-html="getListing(result)"
                >
                </span>
            </li>
            <li v-if="matches.length === 0 && create">
                <button class="text-center active btn btn default search-result w-100" @click="$emit('create', value)">
                    Add New
                </button>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {

        props: {

            value: {
                type: String,
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
                default: 50
            },
            url: {
                type: String,
                required: false
            },
            create: {
                type: Boolean,
                required: false
            }

        },

        data () {
            return {
                open: false,
                current: 0,
                data: [],
            }
        },

        computed: {
            // Filtering the result based on the input
            matches () {
                let matches = this.data.filter((obj) => {
                    return this.getValue(obj).indexOf(this.value) >= 0
                })
                if(matches.length > 10) {
                    matches.length = 10
                }

                return matches
            },

            openResult () {
                return this.selection !== '' &&
                    this.matches.length !== 0 &&
                    this.open === true
            }
        },

        mounted() {
          this.getData()
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
                this.$emit('input', this.getValue(this.matches[this.current]))
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
                            console.log(res.data)
                            $this.data = res.data
                        }
                    })
                    .catch(e => {console.error(e)})
            },

        }

    }
</script>

<style scoped>

    .search-result {
        white-space: nowrap;
        padding-bottom: 3px;
        padding-left: 5px;
        max-width: 400px;
    }
    .search-result:hover {
        color: white;
        background: #4dc0b5;

    }
    .selected-result {
        color: white;
        background: #4dc0b5;
    }
</style>
