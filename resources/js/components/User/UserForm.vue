<template>
    <form @submit.prevent="handleSubmit" class="form-horizontal">

        <div v-if="server_message !== false" class="alert alert-danger" role="alert">
            {{ this.server_message}} <a v-if="try_logging_in" href="/login">Login</a>
        </div>

        <fieldset class="mb-4">
            <legend>General Information</legend>
            <div class="row">
                <!-- Start Column 1 -->
                <div class="col-md-6">

                    <div class="row">
                        <div class="col-md-12">
                            <std-form-group label="Name" label-for="name" :errors="form_errors.name" :required="true">
                                <fld-input
                                        name="name"
                                        v-model="form_data.name"
                                        required
                                />
                                <template slot="help">
                                    Name must be unique.
                                </template>
                            </std-form-group>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <std-form-group display="inline" label="Active" label-for="active"
                                            :errors="form_errors.active">
                                <fld-checkbox name="active" v-model="form_data.active"/>
                                <template slot="help">
                                    Inactive users are unable to log into this system.
                                </template>
                            </std-form-group>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <std-form-group display="inline" label="Role" label-for="role" :errors="form_errors.role">
                                <ui-pick-roles
                                        url="/api-user/role-options"
                                        v-model="form_data.selected_roles"
                                        :selected_roles="roles"
                                        name="user">
                                </ui-pick-roles>
                            </std-form-group>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <std-form-group label="Email" label-for="email" :errors="form_errors.email"
                                            :required="true">
                                <fld-input
                                        type="email"
                                        name="email"
                                        v-model="form_data.email"
                                        required
                                        autocomplete="off"
                                        data-lpignore="true"
                                />
                            </std-form-group>
                        </div>
                    </div>

                </div>
                <!-- End Column 1 -->
            </div>
        </fieldset>

        <fieldset class="mb-4">
            <legend>Password</legend>
            <div class="row">
                <!-- Start Column 1 -->
                <div class="col-md-6">

                    <div class="row">
                        <div class="col-md-12">
                            <std-form-group
                                    :label="this.form_data.id ? 'New Password' : 'Password'"
                                    label-for="password"
                                    :errors="form_errors.password"
                                    :required="this.form_data.id ? false : true"
                            >
                                <vue-password
                                        classes="form-control"
                                        :disable-toggle="false"
                                        name="password"
                                        :score="score"
                                        v-model="form_data.password"
                                        @input="updateScore"
                                        :user-inputs="password_user_inputs"
                                        :required="this.form_data.id ? false : true"
                                        autocomplete="off">
                                    >
                                    <!--The following two slots were added since I could not get the JS score to be the same as the PHP API's -->
                                    <!--https://github.com/skegel13/vue-password/blob/master/src/components/VuePasswordCustom.vue-->
                                    <template v-slot:strength-meter>
                                        <svg viewBox="0 0 123 2" class="VuePassword__Meter" preserveAspectRatio="none">
                                            <path d="M0 1 L30 1" :class="getStrengthClass(0)"></path>
                                            <path d="M31 1 L61 1" :class="getStrengthClass(1)"></path>
                                            <path d="M62 1 L92 1" :class="getStrengthClass(2)"></path>
                                            <path d="M93 1 L123 1" :class="getStrengthClass(3)"></path>
                                        </svg>
                                    </template>

                                    <template v-slot:strength-message>
                                        <div class="VuePassword__Message" :class="strengthClass">{{ message() }}</div>
                                    </template>
                                </vue-password>
                            </std-form-group>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <std-form-group
                                    :label="this.form_data.id ? 'Confirm New Password' : 'Confirm Password'"
                                    label-for="confirm_password"
                                    :errors="form_errors.confirm_password"
                                    :required="this.form_data.id ? false : true"
                            >
                                <input type="password" class="form-control"
                                       name="confirm_password"
                                       @input="validPassword"
                                       v-model="form_data.confirm_password"
                                       autocomplete="off"
                                       :required="this.form_data.id ? false : true"/>
                            </std-form-group>
                        </div>
                    </div>

                </div>
                <!-- End Column 1 -->
            </div>
        </fieldset>


        <div class="form-group mt-4">
            <div class="row">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary" :disabled="processing">
                        <span v-if="this.form_data.id">Change User</span>
                        <span v-else="this.form_data.id">Add User</span>
                    </button>
                </div>
                <div class="col-md-6 text-md-right mt-2 mt-md-0">
                    <a href="/user" class="btn btn-default">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
    import axios from 'axios';
    import UiSelectPickOne from "../SS/UiSelectPickOne";


    export default {
        name: "user-form",
        components: {UiSelectPickOne},
        props: {
            record: {
                type: [Boolean, Object],
                default: false,
            },
            csrf_token: {
                type: String,
                default: ''
            },
            password_user_inputs: {
                type: [Array, Object],
                default() {
                    return []
                }
            },
            roles: {
                type: [Array],
                default() {
                    return []
                }
            },
            /**
             * The following properties were added from the vue-password code since the score set by the JavaScript was
             * different from the score set from the PHP API
             **/
            strengthClasses: {
                type: Array,
                default() {
                    return [
                        'VuePassword--very-weak',
                        'VuePassword--weak',
                        'VuePassword--medium',
                        'VuePassword--good',
                        'VuePassword--great'
                    ]
                }
            },
            strengthMessages: {
                type: Array,
                default() {
                    return [
                        'Very Weak',
                        'Weak',
                        'Medium',
                        'Strong',
                        'Very Strong'
                    ]
                }
            },
        },
        data() {
            return {
                form_data: {
                    // _method: 'patch',
                    _token: this.csrf_token,
                    id: 0,
                    name: '',
                    email: '',
                    active: 1,
                    email_verified_at: '',
                    password: '',
                    confirm_password: '',
                    remember_token: '',
                    selected_roles: '',
                },
                form_errors: {
                    id: false,
                    name: false,
                    email: false,
                    active: false,
                    email_verified_at: false,
                    password: false,
                    confirm_password: false,
                    remember_token: false,
                    selected_roles: false,
                },
                server_message: false,
                try_logging_in: false,
                processing: false,

                score: 0,   // Javascript password strength score
                password_strength: 0,  // PHP password strength score
                changePasswordBtnDisable: true,
            }
        },
        mounted() {
            if (this.record !== false) {
                // this.form_data._method = 'patch';
                Object.keys(this.record).forEach(i => this.form_data[i] = this.record[i])
            } else {
                // this.form_data._method = 'post';
            }

            this.form_data['selected_roles'] = this.roles;

            // THese will never need data from db:
            this.form_data.password = '';
            this.form_data.confirm_password = '';
        },
        methods: {
            async handleSubmit() {

                this.server_message = false;
                this.processing = true;
                let url = '';
                let amethod = '';
                if (this.form_data.id) {
                    url = '/user/' + this.form_data.id;
                    amethod = 'put';
                } else {
                    url = '/user';
                    amethod = 'post';
                }
                await axios({
                    method: amethod,
                    url: url,
                    data: this.form_data
                })
                    .then((res) => {
                        if (res.status === 200) {
                            window.location = '/user';
                        } else {
                            this.server_message = res.status;
                        }
                    }).catch(error => {
                        if (error.response) {
                            if (error.response.status === 422) {
                                // Clear errors out
                                Object.keys(this.form_errors).forEach(i => this.form_errors[i] = false);
                                // Set current errors
                                Object.keys(error.response.data.errors).forEach(i => this.form_errors[i] = error.response.data.errors[i]);
                                this.server_message = 'The given data was invalid. Please correct the fields in red below.';
                            } else if (error.response.status === 404) {  // Record not found
                                this.server_message = 'Record not found';
                                window.location = '/user';
                            } else if (error.response.status === 419) {  // Unknown status
                                this.server_message = 'Unknown Status, please try to ';
                                this.try_logging_in = true;
                            } else if (error.response.status === 500) {  // Unknown status
                                this.server_message = 'Server Error, please try to ';
                                this.try_logging_in = true;
                            } else {
                                this.server_message = error.response.data.message;
                            }
                        } else {
                            console.log(error.response);
                            this.server_message = error;
                        }
                        this.scrollToTop();
                        this.processing = false;
                    });
            },
            /**
             * Go out to the server and get it's score and save in out password_strength field.
             **/
            async updateScore(password, userInputs) {

                this.server_message = false;
                let url = '';
                let amethod = '';
                this.changePasswordBtnDisable = false;

                url = '/password-strength';
                amethod = 'post';

                var user_inputs = [];
                user_inputs.concat(this.form_data.name.split(' '));
                user_inputs.push(this.form_data.email);
                for(var i=0;i<this.form_data.selected_roles.length;i++) {
                    var pieces = this.form_data.selected_roles[i].split('-');
                    for(var j=0;j<pieces.length;j++) {
                        user_inputs.push(pieces[j]);
                    }
                }

                await axios({
                    method: amethod,
                    url: url,
                    data: {
                        password: password,
                        password_user_inputs: this.password_user_inputs.concat(user_inputs)
                    }
                })
                    .then((res) => {
                        if (res.status === 200) {
                            this.password_strength = res.data;
                            this.score = this.password_strength;  // Trying to force JS to be the same as API
                            this.validPassword();
                        } else {
                            this.server_message = res.status;
                        }
                    }).catch(error => {
                        if (error.response) {
                            if (error.response.status === 422) {
                                // Clear errors out
                                Object.keys(this.form_errors).forEach(i => this.form_errors[i] = false);
                                // Set current errors
                                Object.keys(error.response.data.errors).forEach(i => this.form_errors[i] = error.response.data.errors[i]);
                                this.server_message = 'The given data was invalid. Please correct the fields in red below.';
                            } else if (error.response.status === 404) {  // Record not found
                                this.server_message = 'Record not found';

                            } else if (error.response.status === 419) {  // Unknown status
                                this.server_message = 'Unknown Status, please try to ';
                                this.try_logging_in = true;
                            } else if (error.response.status === 500) {  // Unknown status
                                this.server_message = 'Server Error, please try to ';
                                this.try_logging_in = true;
                            } else {
                                this.server_message = error.response.data.message;
                            }
                        } else {
                            this.server_message = error;
                        }
                    });
                this.validPassword();
            },
            /**
             * Verify that passwords match and that the strength is good
             * Set the changePasswordBtnDisable flag
             **/
            validPassword() {
                if (this.form_data.password !== this.form_data.confirm_password) {
                    this.changePasswordBtnDisable = true;
                }
                this.changePasswordBtnDisable = !(this.password_strength > 2);

            },
            /**
             * The following functions were added from the vue-password code since the score set by the JavaScript was
             * different from the score set from the PHP API
             * https://github.com/skegel13/vue-password/blob/master/src/components/VuePasswordCustom.vue
             **/
            getStrengthClass(strength) {
                if (this.password_strength > strength) {
                    return this.strengthClass()
                }
                return ''
            },
            /**
             * Get the current password strength class.
             *
             * @return {string}
             */
            strengthClass() {
                if (this.password_strength >= 0) {
                    if (this.strengthClasses[this.password_strength]) {
                        return this.strengthClasses[this.password_strength]
                    }
                }
            },
            /**
             * Get the current password strength message.
             *
             * @return {string}
             */
            message() {
                if (this.password_strength >= 0) {
                    if (this.strengthMessages[this.password_strength]) {
                        return this.strengthMessages[this.password_strength]
                    }
                }
            },
        },
    }
</script>

