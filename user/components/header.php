<div class="header">
    <div class="user">
    <!-- <i class="lni lni-alarm fs-4 position-relative"></i> -->

        <div style="cursor: pointer" class="user_ops btn-secondary  dropdown-toggle d-flex align-items-center justify-content-center gap-2 cursor-pointer" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="prof">
                <img src="./../assets/<?= $row['picture'] ?>" alt="">
            </div>
            <p class="m-0"><?= $row['fullname'] ?></p>
            <ul class="dropdown-menu dropdown-menu-end">
                <!-- <li><button class="dropdown-item d-flex align-items-center" type="button" data-hystmodal="#setting"><i class="lni lni-cog me-2"></i>Account</button></li> -->
                <li><button class="dropdown-item d-flex align-items-center" data-hystmodal="#logout" type="button"><i class="lni lni-exit me-2"></i>Logout</button></li>
            </ul>
        </div>

    </div>
</div>