<template>
    <div class="d-flex mt-1 ml-2">

        <div class="p-2 input-group">
            <input class="d-inline-block form-control form-control-sm" id="find" type="text" v-model="string"
                   @keyup="findString">
            <div class="dropdown-select" v-if="showDrop">
                <ul>
                    <li v-for="item in items" v-bind:data-id="item.id" @click="setItem(item)">
                        <div class="drop-line">
                            <div v-for="column in columns" class="find" v-bind:class="column">{{ item[column] }}</div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="input-group-append">
                <button class="btn btn-sm btn-outline-info" @click="getView"><i class="fa fa-search"></i></button>
                <button class="btn btn-sm btn-outline-secondary" @click="clearSearch"><i class="fa fa-undo"></i></button>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    props: {
        route: String,
        fields: String,
        search: String
    },
    data() {
        return {
            items: [],
            columns: [],
            message: '',
            showDrop: false,
            string: '',
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
            if (e.key === 'Enter') {
                this.getView();
                return false;
            }
            if (e.key === 'Escape') {
                this.showDrop = false
                return false;
            }
            console.log(e.key);
            axios.post(route, {'string': this.string, 'columns': this.fields})
                .then((r) => {
                    this.showDrop = true;
                    this.items = r.data;
                });
        }, setItem(item) {
            document.location.href = '/' + this.route + '/' + item.id;
            return false;
        }, getView() {
            document.location.href = '/' + this.route + '/find/' + this.string;
        }, clearSearch() {
            document.location.href = '/' + this.route;
        }
    }
}
</script>
