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
                    <select class="form-control" v-model="newStatute.statutes_eligibility_id">
                        <option value="">--Select--</option>
                        <option value="1">Yes</option>
                        <option value="2">No</option>
                        <option value="3">Possibly</option>
                    </select>
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
    export default {
        components: {AddIcon},
        name: "FldStatute",
        props: {
            value: {
                type: String|Number,
                default: '',
            }
        },
        created() {
            this.getData(this.value)
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
                },
                selectedStatute: null,
                selected: false,
                data: [],
                matches: [],
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
                    number: this.newStatute.number
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
                        if(id) {
                            this.matches = this.data
                            if(this.data.length > 0) {
                                for(let i in this.data) {
                                    if(this.data[i].id === this.value) {
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
                    return (d.name + d.number).toLowerCase().indexOf(e) > -1
                })
            },
            onSelect(e) {
                this.selectedStatute = e
                let newId = null
                if(this.selectedStatute) {
                    newId = this.selectedStatute.id
                }

                this.$emit('input', newId)
            }
        }
    }
</script>

<style scoped>
.w-90 {
    width: 90%;
}
</style>
