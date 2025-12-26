<style>
    /*---basic----*/
    a {
        color: #2CC185;
        text-decoration: none;
        outline: none;
    }

    .tab-design-svg {
        position: absolute;
        width: 0;
        height: 0;
        overflow: hidden;
        opacity: 0;
    }

    .reports-tab-section {
        font-size: 1.25em;
    }
    /*-----basic-----*/
</style>
<svg class="hidden tab-design-svg">
    <defs>
        <path id="tabshape" d="M80,60C34,53.5,64.417,0,0,0v60H80z"></path>
    </defs>
</svg>
            
<section class="reports-tab-section">
    <div class="reports-tabs tabs-style-shape">
        <nav>
            <ul>
                <li class="tab-list" id="application">
                    <a type="button" class="btn-report-nav" id="application-btn">
                        <svg viewBox="0 0 80 60" preserveAspectRatio="none"><use xlink:href="#tabshape"></use></svg>
                        <span>APPLICATION</span>
                    </a>
                </li>
                <li class="tab-list" id="daReport" style="display:none;">
                    <a type="button" class="btn-report-nav" id="daReport-btn">
                        <svg viewBox="0 0 80 60" preserveAspectRatio="none"><use xlink:href="#tabshape"></use></svg>
                        <svg viewBox="0 0 80 60" preserveAspectRatio="none"><use xlink:href="#tabshape"></use></svg>
                        <span>DA</span>
                    </a>
                </li>
                <li class="tab-list" id="lmReport" style="display:none;">
                    <a type="button" class="btn-report-nav" id="lmReport-btn">
                        <svg viewBox="0 0 80 60" preserveAspectRatio="none"><use xlink:href="#tabshape"></use></svg>
                        <svg viewBox="0 0 80 60" preserveAspectRatio="none"><use xlink:href="#tabshape"></use></svg>
                        <span>LRA</span>
                    </a>
                </li>
                <li class="tab-list" id="skReport" style="display:none;">
                    <a type="button" class="btn-report-nav" id="skReport-btn">
                        <svg viewBox="0 0 80 60" preserveAspectRatio="none"><use xlink:href="#tabshape"></use></svg>
                        <svg viewBox="0 0 80 60" preserveAspectRatio="none"><use xlink:href="#tabshape"></use></svg>
                        <span>LRS</span>
                    </a>
                </li>
                <li class="tab-list" id="coReport" style="display:none;">
                    <a type="button" class="btn-report-nav" id="coReport-btn">
                        <svg viewBox="0 0 80 60" preserveAspectRatio="none"><use xlink:href="#tabshape"></use></svg>
                        <svg viewBox="0 0 80 60" preserveAspectRatio="none"><use xlink:href="#tabshape"></use></svg>
                        <span>CO</span>
                    </a>
                </li>
                <li class="tab-list" id="boReport" style="display:none;">
                    <a type="button" class="btn-report-nav" id="boReport-btn">
                        <svg viewBox="0 0 80 60" preserveAspectRatio="none"><use xlink:href="#tabshape"></use></svg>
                        <svg viewBox="0 0 80 60" preserveAspectRatio="none"><use xlink:href="#tabshape"></use></svg>
                        <span>BO</span>
                    </a>
                </li>
                <li class="tab-list" id="adcReport" style="display:none;">
                    <a type="button" class="btn-report-nav" id="adcReport-btn">
                        <svg viewBox="0 0 80 60" preserveAspectRatio="none"><use xlink:href="#tabshape"></use></svg>
                        <svg viewBox="0 0 80 60" preserveAspectRatio="none"><use xlink:href="#tabshape"></use></svg>
                        <span>ADC</span>
                    </a>
                </li>
                <li class="tab-list" id="dcReport" style="display:none;">
                    <a type="button" class="btn-report-nav" id="dcReport-btn">
                        <svg viewBox="0 0 80 60" preserveAspectRatio="none"><use xlink:href="#tabshape"></use></svg>
                        <svg viewBox="0 0 80 60" preserveAspectRatio="none"><use xlink:href="#tabshape"></use></svg>
                        <span>DC</span>
                    </a>
                </li>
                <li class="tab-list" id="dptReport" style="display:none;">
                    <a type="button" class="btn-report-nav" id="dptReport-btn">
                        <svg viewBox="0 0 80 60" preserveAspectRatio="none"><use xlink:href="#tabshape"></use></svg>
                        <svg viewBox="0 0 80 60" preserveAspectRatio="none"><use xlink:href="#tabshape"></use></svg>
                        <span>Dept</span>
                    </a>
                </li>
                <li class="tab-list" id="proceeding" style="display:none;">
                    <a type="button" class="btn-report-nav" id="proceeding-btn">
                        <svg viewBox="0 0 80 60" preserveAspectRatio="none"><use xlink:href="#tabshape"></use></svg>
                        <svg viewBox="0 0 80 60" preserveAspectRatio="none"><use xlink:href="#tabshape"></use></svg>
                        <span>PROCEEDING</span>
                    </a>
                </li>
                <li class="tab-list" id="premium" style="display:none;">
                    <a type="button" class="btn-report-nav" id="premium-btn">
                        <svg viewBox="0 0 80 60" preserveAspectRatio="none"><use xlink:href="#tabshape"></use></svg>
                        <svg viewBox="0 0 80 60" preserveAspectRatio="none"><use xlink:href="#tabshape"></use></svg>
                        <span>PREMIUM</span>
                    </a>
                </li>
                <li class="tab-list" id="history" style="display:block;">
                    <a type="button" class="btn-report-nav" id="history-btn">
                        <svg viewBox="0 0 80 60" preserveAspectRatio="none"><use xlink:href="#tabshape"></use></svg>
                        <!-- <svg viewBox="0 0 80 60" preserveAspectRatio="none"><use xlink:href="#tabshape"></use></svg> -->
                        <span>HISTORY</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</section>