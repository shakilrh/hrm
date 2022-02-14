<template>
    <div id="form">
        <form @submit.prevent="editMode ? update() : store()" @keydown="form.onKeydown($event)">
            <alert-error :form="form"></alert-error>
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Name <span class="required-field">*</span></label>
                    <input v-model="form.name" type="text" name="name" id="name" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" placeholder="Enter name"   autofocus>
                    <has-error :form="form" field="name"></has-error>
                </div>

                <div class="form-group">
                    <label class="typo__label">Head Of Department</label>
                    <multiselect v-model="head_of_department_value" :options="users" @select="setHeadOfDeptValue"  placeholder="Select Head Of Department" label="name" track-by="id" name="head_of_department" :class="{ 'multiselect-is-invalid': form.errors.has('head_of_department') }"></multiselect>
                    <div class="multiselect-invalid">
                        <has-error :form="form" field="head_of_department"></has-error>
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
        props:['users','currentDeptHead','department','action','url'],
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
