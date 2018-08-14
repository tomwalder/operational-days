<?php

/**
 * OperationalDaysEnum
 *
 * Enumerates various OperationalDays related constants, in particular bitmask values
 */
interface OperationalDaysEnum {
    const
        /**
         * Enumerated days of week. Follows the date('w') convention that Sunday is zero.
         */
        DOW_SUN = 0,
        DOW_MON = 1,
        DOW_TUE = 2,
        DOW_WED = 3,
        DOW_THU = 4,
        DOW_FRI = 5,
        DOW_SAT = 6,

        /**
         * Bitfield values for day of week. These are defined as 1 << DOW_XXX
         */
        BF_SUN     =   1,
        BF_MON     =   2,
        BF_TUE     =   4,
        BF_WED     =   8,
        BF_THU     =  16,
        BF_FRI     =  32,
        BF_SAT     =  64,
        BF_WEEKDAY =  62,
        BF_WEEKEND =  65,
        BF_ALL     = 127,

        /**
         * Enumerated type of day.
         */
        TYPE_RECURRENT_NON_OPERATIONAL = 0,
        TYPE_RECURRENT_OPERATIONAL     = 1,
        TYPE_SPECIFIC_NON_OPERATIONAL  = 2,
        TYPE_SPECIFIC_OPERATIONAL      = 3
    ;
}

