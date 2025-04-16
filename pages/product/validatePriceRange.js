// Frontend validation of priceRange field.
$('.priceRange').on('change', e => {
    // If a number < 0 is input, change it to 0.
    if (e.target.value < 0) {
        e.target.value = 0;
        return;
    }
});

$('form.priceRangeForm').on('submit', e => {
    // Prevent default behavior, which is submitting the form
    e.preventDefault();
    const $form = e.target;

    const min = $('.priceRange[name=min]')[0];
    const max = $('.priceRange[name=max]')[0];

    // Only switch when both min and max fields have values.
    if (min.value && max.value) {
        const initialMinValue = parseInt(min.value);
        const initialMaxValue = parseInt(max.value);

        if (initialMinValue <= initialMaxValue) {
            // If min and max are valid, submit form
            $form.submit();
            return;
        }

        // min is greater than max! Invalid! Do not submit the form. Alert the user and switch the values for them
        console.log('min is greater than max');
        alert('Error: min value is greater than max value! We\'ve switched the values for you. Please click "Apply" again');
        const temp = initialMinValue;
        min.value = initialMaxValue;
        max.value = temp;
    }
    else {
        // If one or both fields are empty, set empty field(s) to their default values
        if (!min.value) {
            min.value = 0;
        }
        if (!max.value) {
            max.value = 10000;
        }
        $form.submit();
    }
});