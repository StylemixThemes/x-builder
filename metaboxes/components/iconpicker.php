<div>

    <v-style>
        .stm_selected_icon__wrapper {
        position: relative;
        width: 112px;
        margin: 0 0 30px;
        }
        .stm_selected_icon {
        min-height: 54px;
        padding: 8px 15px;
        border: 3px solid #eee;
        }
        .stm_selected_icon span {
        position: relative;
        top: 3px;
        font-size: 17px;
        }
        .stm_selected_icon .selected_icon {
        font-size: 28px;
        position: relative;
        top: 2px;
        }
        .sets {
        position: absolute;
        bottom: 100%;
        left: 107%;
        width: 320px;
        margin-bottom: -54px;
        padding: 10px 15px;
        background-color: #fff;
        box-shadow: 0 0 5px rgba(0,0,0,0.15);
        z-index: 9999999;
        }
        .sets .set h6 {
        margin: 0 0 10px;
        }
        .sets .set {
        max-height: 200px;
        overflow-y: auto;
        }
        .set_icons {
        display: flex;
        padding: 5px 0;
        flex-wrap: wrap;
        justify-content: space-between;
        overflow: hidden;
        }
        .set_icons .set_icon {
        padding: 0 10px 15px;
        font-size: 28px;
        }
        .set_icons .set_icon i{
        display: block;
        }
        .set_icons .set_icon:hover i{
        transform: scale(1.3);
        }
    </v-style>

    <div class="stmt-to-faq">

        <div class="stm_selected_icon__wrapper">
            <div class="stm_selected_icon" @click="openSets = !openSets;">
                <i v-if="newIcon.length" v-bind:class="newIcon" class="selected_icon"></i>
                <span v-else><?php esc_html_e('Set Icon', 'stm'); ?></span>
            </div>
            <div class="sets" v-if="openSets">
                <input v-model="searchQuery" type="text" placeholder="<?php esc_attr_e('Search Icons', 'stm'); ?>"/>
                <span v-if="newIcon.length" @click="newIcon = ''; openSets = false;">Remove Icon</span>
                <div class="set" v-for="(icons, set) in sets">
                    <h6 v-html="set"></h6>
                    <div class="set_icons">
                        <div class="set_icon"
                             v-for="icon in filterItems(icons)"
                             @click="addIcon(icon);">
                            <i v-bind:class="icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>