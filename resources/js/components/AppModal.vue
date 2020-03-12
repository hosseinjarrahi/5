<template>
  <div class="modaler">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">فرم ورود</h5>
          <button type="button" class="close" @click="close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p class="text-danger">نام کاربری و یا رمز ورود اشتباه است.</p>
          <form action method="post">
            <div class="form-group">
              <lable>ایمیل:</lable>
              <input type="text" name="username" class="form-control" />
            </div>
            <div class="form-group">
              <lable>رمز عبور:</lable>
              <input type="password" name="password" class="form-control" />
            </div>
            <a href class="forget password p-2 mb-2">فراموشی رمز عبور</a>
            <button class="btn btn-primary btn-block my-2">ورود</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
          <a href type="button" class="btn btn-primary">ثبت نام</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  methods:{
    close(){
      this.$emit('close');
    }
  }
};
</script>

<style scoped>
.modaler{
  width: 100%;
  height: 100%;
  background: rgba(50, 50, 50, 0.9);
  position: fixed;
  top: 0;
  left: 0;
  z-index: 100;
}
</style>