<template>
    <div>
        <h4>
            Services <span @click="addService">+</span>
        </h4>
        <table class="table  table-sm" >
            <tr class="row"  is="tr-view" v-for="(service,i) in services"
                :key="i"
                v-model="service.pivot.name"
            >
                <span @click="editService(service, i)">{{service.service_type.name}}</span>
            </tr>
        </table>
        <base-modal v-if="showServiceModal" @close="showServiceModal = false">
            <template v-slot:header>Case Service</template>
            <template v-slot:body>
                <div class="form-group">
                    <label class="font-weight-bold">Attn Name</label>
                    <input type="text" required class="form-control"placeholder="Attn Name"
                           v-model="selectedService.pivot.name"
                    >
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Service Name</label>
                    <autocomplete
                        ref="autocomplete"
                        url="/services/all"
                        :create="true"
                        :value="selectedService.name"
                        valueField="name"
                        displayField="address"
                        @selected="selectService"
                        @input="updateService"
                        @create="addNew"
                        :disabled="disableService"
                    ></autocomplete>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Address</label>
                    <input type="text" required class="form-control" placeholder="Address"
                           v-model="selectedService.address"
                            :disabled="disableFields"
                    >
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Phone</label>
                    <input type="text" required class="form-control"
                           placeholder="Phone Number"
                           v-model="selectedService.phone"
                           :disabled="disableFields"
                    >
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Email</label>
                    <input type="text" required class="form-control"
                           placeholder="Email"
                           v-model="selectedService.email"
                           :disabled="disableFields"
                    >
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Note</label>
                    <textarea type="text" required class="form-control"
                           placeholder="Note"
                           v-model="selectedService.note"
                           :disabled="disableFields"
                    ></textarea>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Service Type</label>
                    <select class="form-control" v-model="selectedService.service_type_id" :disabled="disableFields">
                        <option value="">--Select--</option>
                        <option v-for="type in serviceTypes" :value="type.id">{{type.name}}</option>
                    </select>
                </div>
            </template>
            <template v-slot:footer>
                <button class="btn btn-secondary float-left" @click.prevent="showModal = false">Cancel</button>
                <div v-if="disableService">
                    <button type="submit" class="btn btn-danger float-right" @click.prevent="submitDelete">Delete</button>
                    <button type="submit" class="btn btn-primary float-right" @click.prevent="submitEdit">Edit</button>
                </div>
                <div v-else>
                    <button type="submit" class="btn btn-primary float-right" @click.prevent="submitCreate">Create</button>
                </div>
            </template>
        </base-modal>
    </div>
</template>

<script>
    export default {
        name: "ServiceContainer",
        props: {
            services: {
                type: Array|Object,

            },
            case_id: {
                type: Number,
            }
        },
        data() {
            return {
                showServiceModal: false,
                selectedService: {},
                disableFields: true,
                disableService: false,
                newService: {
                    id: null,
                    name: '',
                    address: null,
                    phone: null,
                    email: null,
                    note: null,
                    service_type_id: null,
                    pivot: {
                        name: ''
                    }
                },
                serviceTypes: [],
                selectedIndex: null,
            }
        },
        mounted() {
            this.getServiceTypes()
        },
        methods: {
            addNew() {
                this.disableFields = false
                let name = this.selectedService.name
                Object.assign(this.selectedService, this.newService)
                this.selectedService.name = name
            },
            addService() {
                this.selectedIndex = null
                Object.assign(this.selectedService, this.newService)
                this.showServiceModal = true
                this.disableService = false

            },
            selectService(v) {
                console.log('selectService',v, this.selectedService)
                // keep the name of the pivot so it is overwritten
                v.pivot = {name: this.selectedService.pivot.name}
                Vue.set(this, 'selectedService', v)

                this.disableFields = true
            },
            editService(s, i) {
                this.selectedIndex = i
                this.disableService = true
                this.disableFields = true
                Object.assign(this.selectedService, s)
                this.showServiceModal = true
            },
            submitCreate() {
                console.log('create service')
                let $this = this
                axios.post(`/case/${this.case_id}/service/create`, {
                    name: this.selectedService.pivot.name,
                    service: this.selectedService,
                }).then(res => {
                    console.log(res)
                    $this.selectedService.id = res.data.id
                    $this.selectedService.service_type = res.data.service_type
                    $this.$emit('created', this.selectedService)
                    $this.showServiceModal = false
                }).catch(e => {
                    console.error(e)
                })
            },
            submitDelete() {
                console.log('delete service')
                let $this = this
                axios.delete(`/case/${this.case_id}/service/${this.selectedService.id}`, {
                    name: this.selectedService.pivot.name,
                    service: this.selectedService,
                }).then(res => {
                    console.log(res)
                    this.$emit('deleted', this.selectedService, this.selectedIndex)
                    this.showServiceModal = false
                }).catch(e => {
                    console.error(e)
                })
            },
            submitEdit() {
                console.log('edit service')
                let $this = this
                axios.put(`/case/${this.case_id}/service/${this.selectedService.id}`, {
                    name: this.selectedService.pivot.name,
                    service: this.selectedService,
                }).then(res => {
                    console.log(res)
                    this.$emit('updated', this.selectedService, this.selectedIndex)
                    this.showServiceModal = false
                }).catch(e => {
                    console.error(e)
                })
            },
            // called when input changes
            updateService(v) {
                console.log('updateService',v)
                this.selectedService.name = v
            },
            getServiceTypes() {
                axios.get('/service-types/all')
                    .then(res => {
                        this.serviceTypes = res.data
                    })
                    .catch(e => {console.log(e)})
            }
        }
    }
</script>

<style scoped>

</style>
