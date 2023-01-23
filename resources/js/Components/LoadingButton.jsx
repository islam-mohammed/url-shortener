import React from "react";
import cx from "classnames";
import styles from "../../css/components/LoadingButton.module.css"; // Import css modules stylesheet as styles

export default ({ loading, className, children, ...props }) => {
    const classNames = cx(
        "flex items-center",
        "focus:outline-none",
        {
            "pointer-events-none bg-opacity-75 select-none": loading,
        },
        className
    );
    return (
        <button disabled={loading} className={classNames} {...props}>
            {loading && <div className={`mr-2 ${styles.btnSpinner}`} />}
            {children}
        </button>
    );
};
