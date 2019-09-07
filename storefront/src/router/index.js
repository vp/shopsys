import Vue from 'vue';
import Router from 'vue-router';
import Homepage from "../components/Homepage";
import ProductById from "../components/ProductById";

Vue.use(Router);

const routes = [
  {path: '/storefront/', component: Homepage},
  {path: '/storefront/product/:id', component: ProductById, props: true},
];

const router = new Router({
  routes,
  linkExactActiveClass: 'active',
  mode: 'history',
});

export default router
