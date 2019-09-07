<template>
    <div class="hello">
        <div class="back-link">
            <router-link to="/storefront/">☜ Back to product list</router-link>
        </div>

        <div class="alert alert-warning" role="alert" v-if="errors.length">
            <p v-for="error in errors" :key="error"> {{ error }}</p>
        </div>

        <div v-if="product">
            <h1>{{ product.name }}<small> #{{ product.id }}</small></h1>
            <table>
                <tr>
                    <td>Ean:</td>
                    <td><strong>{{ product.ean }}</strong></td>
                </tr>
                <tr>
                    <td>Part no:</td>
                    <td><strong>{{ product.partno }}</strong></td>
                </tr>
            </table>
            <div><big>Price: {{ product.price.price_with_vat }}</big></div>
            <div><small>Price without VAT: {{ product.price.price_without_vat }}</small></div>

        </div>
        <div v-else>
            No such product found
        </div>
    </div>
</template>

<script>
    export default {
        name: 'ProductById',

        props: ['id'],

        data: function () {
            return {
                product: null,
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
                        "  product(id:" + this.id + ") {" +
                        "    ean" +
                        "    id" +
                        "    partno" +
                        "    name" +
                        "    price {" +
                        "      price_with_vat" +
                        "      price_without_vat" +
                        "    }" +
                        "  }" +
                        "}"
                })
            })
                .then(r => r.json())
                .then(data => this.product = data.data.product)
                .catch(error => {
                    this.errors.push(error);
                });
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    table {
        margin: 1em;
    }

    .back-link {
        margin: 1em 0;
    }

    h1 small {
        font-size: 0.5em;
        color: grey;
        vertical-align: middle;
    }
</style>
