import VueRouter from "vue-router";

let routes = [
  {
    path: '/',
    component: require('./views/Home').default
  },
  {
    path: '/about',
    component: require('./views/About').default
  }
]

export default new VueRouter({
  routes,
  linkActiveClass: 'is-active',
  linkExactActiveClass: ''
})

