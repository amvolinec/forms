<template>
    <div class="d-flex mt-1 ml-2">

        <div class="p-2 input-group">
            <input class="d-inline form-control form-control-sm" id="find" type="text" v-model="string"
                   @keyup="findString">
            <div class="dropdown-select" v-if="showDrop">
                <ul>
                    <li v-for="item in items" v-bind:data-id="item.id" @click="setItem(item)" :class="item.selected">
                        <div class="drop-line">
                            <div v-for="column in columns" class="find" v-bind:class="column">{{ item[column] }}</div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="input-group-append">
                <button class="btn btn-sm btn-outline-info" @click="getView"><i class="fa fa-search"></i></button>
                <button class="btn btn-sm btn-outline-secondary" @click="clearSearch"><i class="fa fa-undo"></i>
                </button>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    props: {
        route: String,
        fields: String,
        search: String,
        isAjax: Boolean
    },
    data() {
        return {
            items: [],
            columns: [],
            message: '',
            showDrop: false,
            string: '',
            isXhr: typeof this.isAjax !== undefined ? this.isAjax : false,
            liSelected: 0
        }
    },
    mounted() {
        this.columns = this.fields.split(',');
        this.string = this.search;
    },
    methods: {
        closePopup() {
            this.$root.$data.nope = false;
        }, findString(e) {
            let route = '/' + this.route + '/find';
            if (e.keyCode === 40 && this.showDrop === true) {

                if (this.liSelected < this.items.length) {
                    this.liSelected++
                } else {
                    this.liSelected = 0;
                }

                this.handleLi();

            }  else if(e.keyCode === 38 && this.showDrop === true) {

                if(this.liSelected > 0) {
                    this.liSelected--
                } else {
                    this.liSelected = this.items.length;
                }

                this.handleLi();

            } else if (e.key === 'Enter' && this.showDrop === true) {

                this.getView();
                return false;

            } else if (e.key === 'Escape' && this.showDrop === true) {

                this.showDrop = false
                return false;

            } else {
                axios.post(route, {'string': this.string, 'columns': this.fields})
                    .then((r) => {
                        this.showDrop = true;
                        this.items = r.data;
                        this.liSelected = 0
                        this.handleLi()
                    });
            }
        }, setItem(item) {
            if(!this.isAjax) {
                document.location.href = '/' + this.route + '/' + item.id;
                return false;
            } else {
                this.$emit('setItem', item.id)
                this.showDrop = false
            }
        }, getView() {
            if(!this.isAjax) {
                document.location.href = '/' + this.route + '/find/' + this.string;
            } else {
                if(this.string.length === 0) {
                    for (let i = 0; i < this.items.length; i++) {
                        if (this.items[i].selected === 'selected') {
                            this.$emit('setItem', this.items[i].id)
                            this.showDrop = false
                            return false;
                        }
                    }
                } else {
                    this.$emit('setItem', this.string)
                }

                this.showDrop = false
            }
        }, clearSearch() {
            if(!this.isAjax) {
                document.location.href = '/' + this.route;
            } else {
                this.$emit('clearSearch', this.string)
            }
        }, handleLi() {
            for (let i = 0; i < this.items.length; i++) {
                if (i === this.liSelected) {
                    this.$set(this.items[i], 'selected', 'selected')
                } else {
                    this.$set(this.items[i], 'selected', '')
                }
            }
        }
    }
}
</script>

<style scoped>
.d-inline.form-control.form-control-sm {
    padding: 16px 10px;
}

.dropdown-select ul li:hover,
.dropdown-select ul li.selected,
.dropdown-select ul li.hover .drop-line,
.dropdown-select ul li.selected .drop-line {
    color: #fff;
    background-color: #3490dc;
}

</style>
