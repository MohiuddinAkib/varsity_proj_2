<?php


namespace App\Contract;


interface IUserRole
{
    const SUPER_ADMIN = "superadmin";
    const HOST_ADMIN = "hostadmin";
    const LOCAL_ADMIN = "localadmin";
    const EMPLOYEE = "employee";
    const CLEANER = "cleaner";
    const FEEDER = "feeder";
    const SWEEPER = "sweeper";
    const HAY_CUTTER = "hay_cutter";
    const GUARD = "guard";
}
