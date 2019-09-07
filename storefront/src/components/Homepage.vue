<template>
    <div>
        <h1>Welcome to the Black Mesa Hazard Course</h1>

        <p v-for="product in products" v-bind:key="product.id">
            <router-link v-bind:to='"/storefront/product/" + product.id'>{{ product.name }}</router-link>
        </p>
    </div>
</template>

<script>
    export default {
        name: 'Homepage',

        data: function () {
            return {
                products: null,
                errors: [],
            };
        },

        created() {
            fetch('/graphql/', {
                method: 'POST',
                mode: 'cors',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    query: "query {" +
                        "  products(categoryId: 3) {" +
                        "    id" +
                        "    name" +
                        "  }" +
                        "}"
                })
            })
                .then(r => r.json())
                .then(data => this.products = data.data.products)
                .catch(error => {
                    this.errors.push(error);
                });
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
