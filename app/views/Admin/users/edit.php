<?php $this->layout('Admin/layout') ;?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content container-fluid">

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Админ-панель</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="">
                        <div class="box-header">
                            <h2 class="box-title">Изменить пользователя</h2>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="col-md-6">
                                <form action="/admin/users/<?php echo $user['id']; ?>/update" method="post">
                                    <div class="form-group">
                                        <label for="exampleInputUserName">Имя</label>
                                        <input type="text" class="form-control" id="exampleInputUserName" value="<?php echo $user['username'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail">Email</label>
                                        <input type="email" class="form-control" id="exampleInputEmail" value="<?php echo $user['email']; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword">Пароль</label>
                                        <input type="password" name="password" class="form-control" id="exampleInputPassword" >
                                    </div>

                                    <div class="form-group">
                                        <label>Роль</label>
                                        <select class="form-control select2" style="width: 100%;" name="roles_mask">
                                            <?php foreach ((new \App\models\Roles())->getRoles() as $role): ?>
                                            <option <?php if($role['id'] == $user['roles_mask']):  ?> selected="selected"<?php endif;?> value="<?php echo $role['id']; ?>"><?php echo $role['title'];  ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputAvatar">Аватар</label>
                                        <input type="file" id="exampleInputAvatar" >
                                        <br>
                                        <img src="<?php echo getImage($user['image']) ?>" width="200" alt="">
                                    </div>

                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="status">
                                                Бан
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button class="btn btn-warning" type="submit">Изменить</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    По вопросам к главному администратору.
                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->

        </section>
        <!-- /.content -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

