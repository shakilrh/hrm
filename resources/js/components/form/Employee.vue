<template>
    <div id="form">
        <form @submit.prevent="editMode ? update() : store()" @keydown="form.onKeydown($event)">
            <alert-error :form="form"></alert-error>
            <div class="card-body">

                <div class="form-row">
                    <div class="col">
                        <div class="form-group">
                            <label for="name">Name </label>
                            <span class="required-field">*</span>
                            <span class="help">e.g. "Jhon"</span>
                            <input v-model="form.name" type="text" name="name" id="name" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" placeholder="Enter Name"   autofocus>
                            <has-error :form="form" field="name"></has-error>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="employee_code">Employee Code Or Id </label>
                            <span class="required-field">*</span>
                            <span class="help">e.g. "E-546814" (Unique For every User)</span>
                            <input v-model="form.employee_code" type="text" name="employee_code" id="employee_code" class="form-control" :class="{ 'is-invalid': form.errors.has('employee_code') }" placeholder="Enter Employee Code" >
                            <has-error :form="form" field="employee_code"></has-error>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col">
                        <div class="form-group">
                            <label for="email">Email </label>
                            <span class="required-field">*</span>
                            <span class="help">e.g. "employee@gmail.com" (Unique For every User)</span>
                            <input v-model="form.email" type="text" name="email" id="email" class="form-control" :class="{ 'is-invalid': form.errors.has('email') }" placeholder="Enter Email"   autofocus>
                            <has-error :form="form" field="email"></has-error>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="username">Username </label>
                            <span class="required-field">*</span>
                            <span class="help">e.g. "employee" (Unique For every User)</span>
                            <input v-model="form.username" type="text" name="username" id="username" class="form-control" :class="{ 'is-invalid': form.errors.has('username') }" placeholder="Enter Username"   autofocus>
                            <has-error :form="form" field="username"></has-error>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col">
                        <div class="form-group">
                            <label for="password">Password </label>
                            <span class="required-field">*</span>
                            <input v-model="form.password" type="password" name="password" id="password" class="form-control" :class="{ 'is-invalid': form.errors.has('password') }" placeholder="Enter Password"   autofocus>
                            <has-error :form="form" field="password"></has-error>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password </label>
                            <span class="required-field">*</span>
                            <input v-model="form.confirm_password" type="text" name="confirm_password" id="confirm_password" class="form-control" :class="{ 'is-invalid': form.errors.has('confirm_password') }" placeholder="Confirm Password"   autofocus>
                            <has-error :form="form" field="confirm_password"></has-error>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col">
                        <div class="form-group">
                            <label class="typo__label">Select Branch</label>
                            <multiselect v-model="branch_value" :options="branches" @select="setBranchValue"  placeholder="Select Branch" label="name" track-by="id" name="branch" :class="{ 'multiselect-is-invalid': form.errors.has('branch') }"></multiselect>
                            <div class="multiselect-invalid">
                                <has-error :form="form" field="branch"></has-error>
                            </div>
                        </div>
                    </div>
                    <div class="col">

                    </div>
                </div>

                <div class="form-group margin-bottom-30px custom-control custom-checkbox">
                    <input  v-model="form.status" type="checkbox" class="custom-control-input" id="status">
                    <label class="custom-control-label" for="status">Active</label>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <a :href="url" class="btn btn-danger pull-right">
                    <i class="fas fa-chevron-circle-left"></i>
                    <span>Back</span>
                </a>
                <button type="submit" class="btn btn-primary">
                    <i v-if="form.busy" class="fas fa-spinner fa-spin"></i>
                    <i v-else class="fas fa-paper-plane"></i>
                    <span>Submit</span>
                </button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        props:['branches','genders','currentDeptHead','department','action','url'],
        data () {
            return {
                editMode: false,
                head_of_department_value:{
                    id: '',
                    name: ''
                },
                form: new Form({
                    head_of_department: '',
                    name: '',
                    status: false,
                }),
            }
        },
        mounted() {
            this.getData()
        },
        methods: {
            getData(){
                if (this.$props.department != null)
                {
                    this.editMode = true
                    this.form.fill(this.$props.department)
                }
                if (this.$props.currentDeptHead != null)
                {
                    this.head_of_department_value.id = this.$props.currentDeptHead.id
                    this.form.head_of_department = this.$props.currentDeptHead.id
                    this.head_of_department_value.name = this.$props.currentDeptHead.name
                }
            },
            setHeadOfDeptValue(selectedOption){
                this.form.head_of_department = selectedOption.id
            },
            store () {
                this.$Progress.start();
                this.form.busy = true;
                // Submit the form via a POST request
                this.form.post(this.$props.action)
                    .then(response => {
                        console.log(response)
                        if (this.form.successful) {
                            this.$Progress.finish()
                            location.href = response.data.redirect;
                        } else {
                            this.$Progress.fail()
                        }
                    })
                    .catch(e => {
                        console.log(e)
                        this.$Progress.fail()
                    })
            },
            update(){
                this.$Progress.start();
                this.form.busy = true;
                // Submit the form via a POST request
                this.form.put(this.$props.action)
                    .then(response => {
                        if (this.form.successful) {
                            this.$Progress.finish()
                            location.href = response.data.redirect;
                        } else {
                            this.$Progress.fail()
                        }
                    })
                    .catch(e => {
                        console.log(e)
                        this.$Progress.fail()
                    })
            }
        }
    }
</script>
