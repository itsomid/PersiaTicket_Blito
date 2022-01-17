@include('panel.layouts.header')
@include('panel.layouts.menu')

<div id="page-wrapper" class="gray-bg">

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="col-lg-10">
            <h2>تهیه کنندگان</h2>
        </div>
        <div class="col-lg-2">
            <a href="#" class="btn btn-primary" style="float: left;margin-bottom: 20px;">ثبت تهیه کننده جدید</a>
        </div>
        <table class="footable table table-stripped toggle-arrow-tiny">
            <thead>
            <tr>
                <th>کد کاربری</th>
                <th>نام کاربری</th>
                <th>نام و نام خانوادگی</th>
                <th>شرکت</th>
                <th>ایمیل</th>
                <th>تلفن تماس</th>
                <th>موبایل</th>
                <th>ویرایش</th>


            </tr>
            </thead>
            <tbody>
            <?php for ($x=0 ;$x < 20 ; $x++ ) { ?>
                <tr>
                    <td>4253</td>
                    <td>Cinama</td>
                    <td>محمد یراقی</td>
                    <td>ایده پردازان سیب</td>
                    <td>test_email@gmail.com</td>
                    <td>021-8823243</td>
                    <td>09123456789</td>
                    <td><a href="producer-edite.php" class="btn btn-sm btn-primary" >ویرایش</a> </td>
                </tr>
            <?php } ?>

            </tbody>
        </table>
    </div>
</div>

<?php include ('footer.php');?>
