<template>
    <div id="form">
        <form @submit.prevent="editMode ? update() : store()" @keydown="form.onKeydown($event)">
            <!-- Alert -->
<!--            <div class="pr-2 pl-2">
            </div>-->
            <alert-error :form="form"></alert-error>

            <div class="card-body">
                <div class="form-group">
                    <label for="name">Name <span class="required-field">*</span></label>
                    <input v-model="form.name" type="text" name="name" id="name" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" placeholder="Enter name"  required autofocus>
                    <has-error :form="form" field="name"></has-error>
                </div>

                <div class="form-group">
                    <label for="address">Address <span class="required-field">*</span></label>
                    <textarea v-model="form.address" type="text" name="address" id="address" class="form-control" :class="{ 'is-invalid': form.errors.has('address') }" rows="4" required></textarea>
                    <has-error :form="form" field="address"></has-error>
                </div>

                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input v-model="form.phone" type="tel" name="phone" id="phone" class="form-control" :class="{ 'is-invalid': form.errors.has('phone') }" placeholder="Enter phone">
                    <has-error :form="form" field="phone"></has-error>
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
        props:['branch','action','url'],
        data () {
            return {
                editMode: false,
                form: new Form({
                    name: '',
                    address: '',
                    phone: '',
                    status: false,
                }),
            }
        },
        mounted() {
            this.getData()
        },
        methods: {
            getData(){
                if (this.$props.branch != null)
                {
                    this.editMode = true
                    this.form.fill(this.$props.branch)
                }
            },
            store () {
                this.$Progress.start();
                this.form.busy = true;
                // Submit the form via a POST request
                this.form.post(this.$props.action)
                    .then(response => {
                        if (this.form.successful) {
                            this.$Progress.finish()
                            // console.log(response)
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
                            // console.log(response)
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
