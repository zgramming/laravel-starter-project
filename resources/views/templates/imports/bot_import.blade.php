{{-- Jquery --}}
<script src="{{asset('assets/vendors/jquery/jquery.min.js')}}"></script>

{{-- Scroll JS --}}
<script src="{{asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>

{{-- DataTable --}}
<script src="{{asset('assets/vendors/jquery-datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js')}}"></script>

{{-- Choices Select (Select2) --}}
<script src="{{asset('assets/vendors/choices.js/choices.min.js')}}"></script>

{{-- Font Awesome 5 --}}
<script src="{{asset('assets/vendors/fontawesome/all.min.js')}}"></script>

{{-- Core Template --}}
<script src="{{asset('assets/js/mazer.js')}}"></script>

{{-- Custom File --}}

<script type="text/javascript">

    $(document).ready(function(e){
        /// Initialize Select Choices Plugin
        initSelectChoices();

        /// Set Default Toggle Filter Content to hidden
        $(".toggle-more-filter-content").hide();

        $(".toggle-more-filter").on('click',function(e){
            let child = $(this).children();
            let isPlusIcon = child.hasClass('fa-plus');
            if(isPlusIcon)  child.removeClass('fa-plus').addClass('fa-minus');
            else child.removeClass('fa-minus').addClass('fa-plus');

            /// Toggle Filter Content
            $(".toggle-more-filter-content").toggle('fast');
        })
    });

    // [https://stackoverflow.com/questions/28948383/how-to-implement-debounce-fn-into-jquery-keyup-event
    // [http://davidwalsh.name/javascript-debounce-function]
    function debounce(func, wait, immediate) {
        let timeout;
        return function() {
            const context = this, args = arguments;
            const later = function () {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    }

    function initSelectChoices(){
        let choices = document.querySelectorAll('.choices');
        let initChoice;
        for(let i=0; i<choices.length;i++) {
            if (choices[i].classList.contains("multiple-remove")) {
                initChoice = new Choices(choices[i],
                {
                    delimiter: ',',
                    editItems: true,
                    maxItemCount: -1,
                    removeItemButton: true,
                });
            }else{
                initChoice = new Choices(choices[i]);
            }
        }

    }
</script>
