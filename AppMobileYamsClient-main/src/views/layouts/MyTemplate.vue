<template>
  <ion-page>
    <NavBar></NavBar>
    <ion-content>
        <slot name="content"></slot>
    </ion-content>
    <BottomBar></BottomBar>
  </ion-page>
</template>

<script>
import BottomBar from './BottomBar.vue';
import NavBar from './NavBar.vue';

export default {
  components: { BottomBar, NavBar }
}
</script>