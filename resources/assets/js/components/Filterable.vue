<template>
    <div class="filterable">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title">
                    <span>Customers match</span>
                    <select v-model="query.filter_match">
                        <option value="and">All</option>
                        <option value="or">Any</option>
                    </select>
                    <span>of the following:</span>
                </div>
            </div>
            <div class="panel-body">
                <table class="table">
                    <slot name="thead"></slot>
                    <tbody>
                    <slot v-if="collection.data && collection.data.length"
                          v-for="item in collection.data"
                          :item="item"
                          ></slot>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    import Vue from 'vue'
    import axios from 'axios'
    export default {
        props: {
            url: String
        },
        data() {
            return {
                loading:true,
                query: {
                    order_column: 'created_at',
                    order_direction: 'desc',
                    filter_match: 'and',
                    limit: 10,
                    page: 1
                },
                collection: {
                    data: []
                }
            }
        },
        mounted() {
            this.fetch()
        },
        methods: {
            fetch(){
                axios.get(this.url)
                    .then(res => {
                    Vue.set(this.$data,'collection',res.data.collection);
                    this.query.page = res.data.collection.current_page;
                    })
                    .catch(error => {

                    })
                    .finally(() => {
                        this.loading = false
                    })
            }
        }
    }
</script>