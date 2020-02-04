<template>
    <div class="">

        <v-select label="name" :filterable="false" :searchable="true"
                  class="d-inline-block w-90"
                  v-model="selectedStatute"
                  :options="matches"
                  @input="onSelect"
                  @search="onSearch">
            <template slot="no-options">
            </template>
            <template slot="option" slot-scope="option">
                <div class="d-center">
                    {{ option.number }} - {{ option.name }}
                </div>
            </template>
            <template slot="selected-option" slot-scope="option">
                <div class="selected d-center">
                    {{ option.number }} - {{ option.name }}
                </div>
            </template>
        </v-select>

        <add-icon
                @click="showModal = true"
                :height="25"
        />

        <base-modal v-if="showModal" @close="showModal = false">
            <template v-slot:header>Create New Statute</template>
            <template v-slot:body>

                <div class="form-group">
                    <label class="font-weight-bold">Jurisdiction Type</label>
                    <v-select label="name"
                              :filterable="false"
                              v-model="selected_jurisdiction_type"
                              :options="jurisdiction_types"
                              @input="filterJurisdictionsByType"
                    >
                    </v-select>
                </div>

                <jurisdiction-create-modal ref="jurisdictionModal" @add="addJurisdiction"/>

                <div class="form-group mb-1">
                    <label class="font-weight-bold">Jurisdiction</label>
                </div>
                <div class="form-group">
                    <v-select label="name"
                                class="d-inline-block w-50"
                                :filterable="false"
                                v-model="newStatute.jurisdiction_id"
                                :options="jurisdictions"
                    >
                    </v-select>
                    <add-icon
                        @click="$refs.jurisdictionModal.showModal = true"
                        :height="25"
                    />
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Number</label>
                    <input type="text" required class="form-control" placeholder="Statute Number"
                           v-model="newStatute.number">
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Name</label>
                    <input type="text" required class="form-control" v-model="newStatute.name"
                           placeholder="Statute Name">
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Is Expungeable?</label>
                    <ui-select-pick-one
                            url="/api-statutes-eligibility/options"
                            v-model="newStatute.statutes_eligibility_id"
                            :selected_id="newStatute.statutes_eligibility_id"
                            name="statutes_eligibility"
                            blank_value="0"
                            additional_classes="mb-2 grid-filter"
                            styleAttr="max-width: 175px;"
                            required/>
                </div>
            </template>
            <template v-slot:footer>
                <button class="btn btn-secondary float-left" @click.prevent="showModal = false">Cancel</button>
                <button type="submit" class="btn btn-primary float-right" @click.prevent="createStatute">Submit</button>
            </template>
        </base-modal>

    </div>
</template>


<script>
    import AddIcon from "../controls/AddIcon";
    import UiSelectPickOne from "../SS/UiSelectPickOne";

    export default {
        components: {
            AddIcon,
            UiSelectPickOne
        },
        name: "FldStatute",
        props: {
            value: {
                type: String | Number,
                default: '',
            },
            filters: {
                default: null,
                type: Object
            }
        },
        created() {
            this.getData(this.value)
            this.getJurisdictionTypes()
            this.getJurisdictions()
        },
        mounted() {

        },
        data() {
            return {
                showModal: false,
                newStatute: {
                    name: null,
                    number: null,
                    statutes_eligibility_id: null,
                    jurisdiction_id: null,
                },
                selectedStatute: null,
                selected: false,
                data: [],
                matches: [],
                selected_jurisdiction_type: null,
                jurisdiction_types: [],
                jurisdictions: [],
            }
        },
        methods: {
            statuteSelected(v) {
                this.selected = true
                this.$emit('selected', v)
            },
            createStatute() {
                let $this = this
                axios.post('/statute', {
                    statutes_eligibility_id: this.newStatute.statutes_eligibility_id,
                    name: this.newStatute.name,
                    number: this.newStatute.number,
                    jurisdiction_id: this.newStatute.jurisdiction_id.id
                }).then(res => {
                    $this.newStatute = {}
                    $this.selectedStatute = res.data
                    $this.updateStatute($this.selectedStatute.id)
                    $this.showModal = false
                    $this.getData($this.selectedStatute.id)
                }).catch(e => {
                    console.error(e)
                })
            },
            updateStatute(v) {
                this.selected = false
                this.$emit('input', v)
            },
            getData(id = null) {

                let $this = this
                axios.get('/statutes/all')
                    .then(res => {
                        if (res.data) {
                            $this.data = res.data
                        }

                        if (id) {
                            this.matches = this.data
                            if (this.data.length > 0) {
                                for (let i in this.data) {
                                    if (this.data[i].id === this.value) {
                                        this.selectedStatute = this.data[i]
                                    }
                                }

                            }
                        }
                    })
                    .catch(e => {
                        console.error(e)
                    })
            },
            onSearch(e) {
                this.matches = this.data.filter(d => {
                    return (d.name + '' + d.number).toLowerCase().indexOf(e.toLowerCase()) > -1
                })
                if(this.filters) {

                    this.matches = this.filterBy(this.matches)
                }
            },

            filterBy(matches) {

                for(let key in this.filters) {
                    matches = matches.filter((s) => {

                        if(Array.isArray(this.filters[key])) {
                            for(let value in this.filter[key]) {
                                if(s[key] === this.filter[key][value]) {
                                    return true
                                }
                            }
                        } else {
                            return s[key] === this.filters[key]
                        }

                        return false

                    })
                }

                return matches
            },

            onSelect(e) {
                this.selectedStatute = e
                let newId = null
                if (this.selectedStatute) {
                    newId = this.selectedStatute.id
                }

                this.$emit('input', newId)
            },

            addJurisdiction(j) {
                if(j && j.id > 0) {
                    this.jurisdictions.push(j)
                    this.newStatute.jurisdiction_id = j
                }
            },

            getJurisdictions() {
                axios.get('/api-jurisdiction')
                    .then((res) => {
                        this.all_jurisdictions = res.data.data

                        this.jurisdictions = this.all_jurisdictions
                    })
                    .catch(e => console.error(e))
            },

            getJurisdictionTypes() {
                axios.get('/api-jurisdiction-type')
                    .then((res) => {
                        this.jurisdiction_types = res.data.data
                    })
                    .catch(e => console.error(e))
            },

            filterJurisdictionsByType(e) {
                this.jurisdictions = this.all_jurisdictions.filter(j => {
                    return j.jurisdiction_type_id === e.id
                })

            },
        }
    }
</script>

<style scoped>
    .w-90 {
        width: 90%;
    }
</style>
