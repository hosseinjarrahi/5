<template>
  <div class="parent-title">
    <div class="title p-2">
      <slot></slot>
    </div>
  </div>
</template>

<script>
export default {

}
</script>

<style>
.parent-title{
  border-bottom: 2px solid #f5f5f5;
  position: relative;
  display: flex;
  justify-content: center;
  width: 100%;
}
.title{
  position: absolute;
  top: -40px;
  border-radius: 10px 10px 0px 0px;
  background-color: #f5f5f5;
  color: #2f3542;
  font-weight: bold;
}
</style>