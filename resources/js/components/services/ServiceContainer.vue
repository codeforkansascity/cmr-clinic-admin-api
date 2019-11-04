<template>
    <div>
        <h4>
            Service <span @click="addService" class="add-button">+</span>
        </h4>
        <table class="table  table-sm">
            <tr class="row" v-for="(service,i) in services"
                :key="i"
            >
                <td class="service-name-column">
                   <span class="service-name-field">
                        {{service.service_type.name}}
                    </span>
                </td>
                <td>
                    {{service.name}} Attn: {{service.pivot.name}}
                </td>
                <td>
                    <pencil-control height="25"
                                    @click="editService(service, i)"/>
                </td>
            </tr>
        </table>
        <base-modal v-if="showServiceModal" @close="closeModal">
            <template v-slot:header>Case Service</template>
            <template v-slot:body>
                <std-form-group :errors="form_errors.service.name">
                    <label class="font-weight-bold">Service Name</label>
                    <autocomplete
                            style="width: 100%"
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
                </std-form-group>
                <std-form-group :errors="form_errors.service.service_type_id">
                    <label class="font-weight-bold">Service Type</label>
                    <select class="form-control" v-model="selectedService.service_type_id" >
                        <option value="">--Select--</option>
                        <option v-for="type in serviceTypes" :value="type.id">{{type.name}}</option>
                    </select>
                </std-form-group>
                <std-form-group :errors="form_errors.name">
                    <label class="font-weight-bold">Attn Name</label>
                    <input type="text" required class="form-control" placeholder="Attn Name"
                           v-model="selectedService.pivot.name"
                    >
                </std-form-group>

                <std-form-group :errors="form_errors.service.address">
                    <label class="font-weight-bold">Address</label>
                    <input type="text" required class="form-control" placeholder="Address"
                           v-model="selectedService.address"
                           :disabled="disableFields"
                    >
                </std-form-group>
                <std-form-group :errors="form_errors.service.phone">
                    <label class="font-weight-bold">Phone</label>
                    <input type="text" required class="form-control"
                           placeholder="Phone Number"
                           v-model="selectedService.phone"
                           :disabled="disableFields"
                    >
                </std-form-group>
                <std-form-group :errors="form_errors.service.email">
                    <label class="font-weight-bold">Email</label>
                    <input type="text" required class="form-control"
                           placeholder="Email"
                           v-model="selectedService.email"
                           :disabled="disableFields"
                    >
                </std-form-group>
                <std-form-group :errors="form_errors.service.note">
                    <label class="font-weight-bold">Note</label>
                    <textarea type="text" required class="form-control"
                              placeholder="Note"
                              v-model="selectedService.note"
                              :disabled="disableFields"
                    ></textarea>
                </std-form-group>

            </template>
            <template v-slot:footer>
                <button class="btn btn-secondary float-left" @click.prevent="closeModal">Cancel</button>
                <div v-if="disableService">
                    <button type="submit" class="btn btn-danger float-right" @click.prevent="submitDelete">Delete
                    </button>
                    <button type="submit" class="btn btn-primary float-right" @click.prevent="submitEdit">Edit</button>
                </div>
                <div v-else>
                    <button type="submit" class="btn btn-primary float-right" @click.prevent="submitCreate">Create
                    </button>
                </div>
            </template>
        </base-modal>
    </div>
</template>

<script>
    import PencilControl from "../controls/PencilControl";

    export default {
        components: {PencilControl},
        name: "ServiceContainer",
        props: {
            services: {
                type: Array | Object,

            },
            case_id: {
                type: Number,
            }
        },
        data() {
            return {
                showServiceModal: false,
                selectedService: {
                    name: ''
                },
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
                form_errors: {
                    name: false,
                    service: {
                        id: false,
                        name: false,
                        address: false,
                        phone: false,
                        email: false,
                        note: false,
                        service_type_id: false,
                    }
                }
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
                console.log('selectService', v, this.selectedService)

                if (!this.selectedService.attn) {
                    this.selectedService.attn = "Court Clerk";
                }

                this.selectedService.pivot.name = this.selectedService.attn;

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
                // if (!this.selectedService.attn) {
                //     this.selectedService.attn = "Court Clerk";
                // }
                //
                // this.selectedService.pivot.name = this.selectedService.attn;

                let $this = this
                axios.post(`/case/${this.case_id}/service/create`, {
                    name: this.selectedService.pivot.name,
                    service: this.selectedService,
                }).then(res => {
                    console.log(res)
                    $this.selectedService.id = res.data.id
                    $this.selectedService.service_type = res.data.service_type
                    $this.$emit('created', this.selectedService)
                    this.closeModal()
                }).catch(e => {
                    for (let name in e.response.data.errors) {
                        let split = name.split('.')
                        if (split.length > 1) {
                            $this.form_errors[split[0]][split[1]] = e.response.data.errors[name]
                        } else {
                            $this.form_errors[name] = e.response.data.errors[name]
                        }
                    }

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
                    this.closeModal()
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
                    this.closeModal()
                }).catch(e => {
                    console.error(e)
                    for (let name in e.response.data.errors) {
                        $this.form_errors[name] = e.response.data.errors[name]
                    }
                })
            },
            // called when input changes
            updateService(v) {
                console.log('updateService', v)
                this.selectedService.name = v
            },
            getServiceTypes() {
                axios.get('/service-types/all')
                    .then(res => {
                        this.serviceTypes = res.data
                    })
                    .catch(e => {
                        console.log(e)
                    })
            },
            resetErrors() {
                this.form_errors = {
                    name: false,
                    service: {
                        id: false,
                        name: false,
                        address: false,
                        phone: false,
                        email: false,
                        note: false,
                        service_type_id: false,
                    }
                }
            },
            closeModal() {
                this.showServiceModal = false
                this.resetErrors()
            }
        }
    }
</script>

<style scoped>
    .service-name-column {
        width: 12em;
    }

    .service-name-field {
        color: darkgray;
    }

    .name-field:hover {
        font-weight: bolder;
        color: #343a40;
        cursor: pointer;
    }

    .add-button {
        color: #aaaaaa;
        font-weight: normal;
    }

    .add-button:hover {
        color: #343a40;
        font-weight: bolder;
        cursor: pointer;
    }

</style>
