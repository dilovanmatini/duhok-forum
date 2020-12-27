/*//////////////////////////////////////////////////////////
// ######################################################///
// # DuhokForum 1.1                                     # //
// ###################################################### //
// #                                                    # //
// #       --  DUHOK FORUM IS FREE SOFTWARE  --         # //
// #                                                    # //
// #   ========= Programming By Dilovan ==============  # //
// # Copyright © 2007-2009 Dilovan. All Rights Reserved # //
// #----------------------------------------------------# //
// #----------------------------------------------------# //
// # If you want any support vist down address:-        # //
// # Email: df@duhoktimes.com                           # //
// # Site: http://df.duhoktimes.com/index.php           # //
// ###################################################### //
//////////////////////////////////////////////////////////*/

var hidecounter = false;
var your_max_size = 0;
var edit = true;


if((editor_method == 'topic') || (editor_method == 'edit')){
	your_max_size = topic_max_size;
}
else if((editor_method == 'reply') || (editor_method == 'editreply')){
	your_max_size = reply_max_size;
}
else if((editor_method == 'sendmsg') || (editor_method == 'replymsg')){
	your_max_size = pm_max_size;
}
else if(editor_method == 'sig'){
	your_max_size = sig_max_size;
}
else{
	your_max_size = 512000;
}

function show_text_count(){
	if(obj1.displayMode != "HTML"){
		var c = update_text_count(1);
		var notice = ed_cur_size + ": " + obj1.getContentBody().length;
		if(your_max_size > 0){
			notice += "\r\n\r\n" + ed_max_size + ": " + your_max_size;
		}
		if(obj1.getContentBody().length > your_max_size){
			notice += "\r\n\r\n" + ed_too_big;
		}
		confirm(notice);
	}
}

function update_text_count(mode){
	var result = 0;
	if(obj1.displayMode == "HTML"){
		editor_form.status.style.background = "#99ff99";
		editor_form.status.style.color = "red";
		editor_form.status.value = "H T M L";
	}
	else{
		var c = obj1.getContent(1);
		result = c;
		if((mode == 0) && (hidecounter)){
			return(-1);
		}
		if(c >= 0){
			editor_form.status.style.background = "#ffff99";
			editor_form.status.style.color = "brown";
			editor_form.status.value = ed_cur_size;
			hidecounter = true;
			return(c);
		}
		else if(your_max_size == 0){
			editor_form.status.style.background = "#ffff99";
			editor_form.status.style.color = "brown";
			editor_form.status.value = ed_cur_size + ": " + obj1.getContentBody().length;
		}
		else{
			if(obj1.getContentBody().length > your_max_size){
				editor_form.status.style.background = "red";
				editor_form.status.style.color = "white";
			}
			else{
				editor_form.status.style.background = "#ffff99";
				editor_form.status.style.color = "brown";
			}
			editor_form.status.value = obj1.getContentBody().length + " / " + your_max_size;
		}
	}
	var tmr = 600;
	if(result < 1000){
		tmr = 1000;
	}
	else if(result < 2000){
		tmr = 2000;
	}
	else if(result < 5000){
		tmr = 3500;
	}
	setTimeout('update_text_count(0)',tmr);
	return(result);
}

function copy_right(){
	if(ed_copy_right != ""){
		alert(ed_copy_right);
		return;
	}
}

function submit_form(){
	var method = editor_form.method.value;
	if(obj1.displayMode == "HTML"){
		alert(ed_uncheck_html)
		return ;
	}
	if((method == "topic") || (method == "edit") || (method == "sendmsg") || (method == "replymsg")){
		if(editor_form.subject.value == ""){
			alert(ed_need_title)
			return ;
		}
	}
	editor_form.message.value = obj1.getContentBody();
	editor_form.txtPageProperties.value = obj1.getPageCSSText();

	if((editor_form.message.value == "") || (editor_form.message.value == "<P>&nbsp;</P>") || (editor_form.message.value == "<P></P>")){
		alert(ed_need_content)
		return ;
	}
	var box = editor_form.message.value.length;
	if(box > your_max_size){
		alert(ed_too_big)
		return ;
	}
	if((method == "topic") || (method == "edit")){
		if(box > topic_max_size){
			alert(ed_too_big)
			return ;
		}
	}
	if((method == "reply") || (method == "editreply")){
		if(box > reply_max_size){
			alert(ed_too_big)
			return ;
		}
	}
	if((method == "sendmsg") || (method == "replymsg")){
		if(box > pm_max_size){
			alert(ed_too_big)
			return ;
		}
	}
	if(method == "sig"){
		if(box > sig_max_size){
			alert(ed_too_big)
			return ;
		}
	}
	if(confirm(ed_confirm_submit)){
                                    edit = false;
		editor_form.submit();
	}
}

function load_content(){
obj1.putContent(idtextarea.value);
obj1.setPageCSSText(editor_style);
}


var smiliesPaths = new Array (
	"icon_smile",
	"smilies/animals/",
	"smilies/faces/",
	"smilies/faces/",
	"smilies/faces/",
	"smilies/faces/",
	"smilies/faces/",
	"smilies/food/",
	"smilies/objects/",
	"smilies/people/",
	"smilies/people/",
	"smilies/sports/",
	"smilies/planets/"
);

var smiliesWidths = new Array (
	3,
	3,
	3,
	3,
	3,
	3,
	3,
	3,
	3,
	3,
	3,
	3,
	3
);

var smiliesList = new Array (
	0,".gif",
	0,"_big.gif",
	0,"_cool.gif",
	0,"_blush.gif",
	0,"_tongue.gif",
	0,"_evil.gif",
	0,"_wink.gif",
	0,"_clown.gif",
	0,"_blackeye.gif",
	0,"_8ball.gif",
	0,"_sad.gif",
	0,"_shy.gif",
	0,"_shock.gif",
	0,"_angry.gif",
	0,"_dead.gif",
	0,"_kisses.gif",
	0,"_approve.gif",
	0,"_dissapprove.gif",
	0,"_sleepy.gif",
	0,"_question.gif",
	0,"_rotating.gif",
	0,"_eyebrows.gif",
	0,"_hearteyes.gif",
	0,"_crying.gif",
	0,"_waving.gif",
	0,"_waving2.gif",
	0,"_nono.gif",
	0,"_wailing.gif",
	0,"_joker.gif",

	1,"animals_bear[1].gif",
	1,"animals_cat[1].gif",
	1,"animals_cock[1].gif",
	1,"animals_dog[1].gif",
	1,"animals_fish[1].gif",
	1,"animals_fox[1].gif",
	1,"animals_frog[1].gif",
	1,"animals_giraffe[1].gif",
	1,"animals_gorilla[1].gif",
	1,"animals_hen[1].gif",
	1,"animals_hippo[1].gif",
	1,"animals_horse[1].gif",
	1,"animals_leopard[1].gif",
	1,"animals_monkey[1].gif",
	1,"animals_monster[1].gif",
	1,"animals_mouse[1].gif",
	1,"animals_penguin[1].gif",
	1,"animals_pig[1].gif",
	1,"animals_racoon[1].gif",
	1,"animals_serpent[1].gif",
	1,"animals_tiger[1].gif",
	1,"animals_turtle[1].gif",

	2,"faces_accident[1].gif",
	2,"faces_amazed[1].gif",
	2,"faces_angry[1].gif",
	2,"faces_anxious[1].gif",
	2,"faces_appetizing[1].gif",
	2,"faces_ashamed[1].gif",
	2,"faces_astonished[1].gif",
	2,"faces_balloon[1].gif",
	2,"faces_bandage[1].gif",
	2,"faces_bitter[1].gif",
	2,"faces_black_eye[1].gif",
	2,"faces_blind[1].gif",
	2,"faces_cautious[1].gif",
	2,"faces_chagrined[1].gif",
	2,"faces_cloudy[1].gif",
	2,"faces_confident[1].gif",
	2,"faces_confused[1].gif",
	2,"faces_congratulate[1].gif",
	2,"faces_cool[1].gif",
	2,"faces_cyclop[1].gif",
	2,"faces_dead[1].gif",
	2,"faces_deceived[1].gif",
	2,"faces_deep_trouble[1].gif",
	2,"faces_depressed[1].gif",
	2,"faces_disapointed[1].gif",
	2,"faces_disgusted[1].gif",
	2,"faces_dreaming[1].gif",

	3,"faces_dumb[1].gif",
	3,"faces_ecstatic[1].gif",
	3,"faces_embarassed[1].gif",
	3,"faces_encouraging[1].gif",
	3,"faces_enraged[1].gif",
	3,"faces_evolution[1].gif",
	3,"faces_exhausted[1].gif",
	3,"faces_eyes_shut[1].gif",
	3,"faces_fathers_day[1].gif",
	3,"faces_fight[1].gif",
	3,"faces_flirt[1].gif",
	3,"faces_forbidden[1].gif",
	3,"faces_freezing[1].gif",
	3,"faces_friendly[1].gif",
	3,"faces_frustrated[1].gif",
	3,"faces_glad[1].gif",
	3,"faces_greedy[1].gif",
	3,"faces_guilty[1].gif",
	3,"faces_happy[1].gif",
	3,"faces_happy_(f)[1].gif",
	3,"faces_hilarious[1].gif",
	3,"faces_hopeful[1].gif",
	3,"faces_hurt[1].gif",
	3,"faces_hysterical[1].gif",
	3,"faces_imaginative[1].gif",
	3,"faces_indifferent[1].gif",
	3,"faces_innocent[1].gif",

	4,"faces_jealous[1].gif",
	4,"faces_kiss[1].gif",
	4,"faces_laughing[1].gif",
	4,"faces_liar[1].gif",
	4,"faces_listen_to_music[1].gif",
	4,"faces_lonely[1].gif",
	4,"faces_lovestruck[1].gif",
	4,"faces_love_(F)[1].gif",
	4,"faces_love_(M)[1].gif",
	4,"faces_lucky[1].gif",
	4,"faces_mad[1].gif",
	4,"faces_male[1].gif",
	4,"faces_melting[1].gif",
	4,"faces_mischievous[1].gif",
	4,"faces_mocking[1].gif",
	4,"faces_mothers_day[1].gif",
	4,"faces_mute[1].gif",
	4,"faces_nasty[1].gif",
	4,"faces_near_sighted[1].gif",
	4,"faces_nice[1].gif",
	4,"faces_nocturnal[1].gif",
	4,"faces_obnoxious[1].gif",
	4,"faces_overwhelmed[1].gif",
	4,"faces_peace[1].gif",
	4,"faces_perplex[1].gif",
	4,"faces_playboy[1].gif",
	4,"faces_questioning[1].gif",

	5,"faces_rosey_cheek[1].gif",
	5,"faces_sad[1].gif",
	5,"faces_scar[1].gif",
	5,"faces_scared[1].gif",
	5,"faces_screaming[1].gif",
	5,"faces_septical[1].gif",
	5,"faces_sheming[1].gif",
	5,"faces_shocked[1].gif",
	5,"faces_shy[1].gif",
	5,"faces_siamese_twins[1].gif",
	5,"faces_sick[1].gif",
	5,"faces_singing[1].gif",
	5,"faces_sleep[1].gif",
	5,"faces_slobber[1].gif",
	5,"faces_smart[1].gif",
	5,"faces_smug[1].gif",
	5,"faces_sorry[1].gif",
	5,"faces_strained[1].gif",
	5,"faces_stressed[1].gif",
	5,"faces_suffering[1].gif",
	5,"faces_sunny[1].gif",
	5,"faces_surprised[1].gif",
	5,"faces_suspicious[1].gif",
	5,"faces_sympathising[1].gif",
	5,"faces_tearful[1].gif",
	5,"faces_thinking[1].gif",
	5,"faces_threatening[1].gif",

	6,"faces_tired[1].gif",
	6,"faces_together[1].gif",
	6,"faces_tongue_tied[1].gif",
	6,"faces_uncertain[1].gif",
	6,"faces_unconscious[1].gif",
	6,"faces_unhappy[1].gif",
	6,"faces_upset[1].gif",
	6,"faces_valentines_day[1].gif",
	6,"faces_very_ashamed[1].gif",
	6,"faces_very_sorry[1].gif",
	6,"faces_whimsical[1].gif",
	6,"faces_windy[1].gif",
	6,"faces_wry[1].gif",
	6,"faces_yawning[1].gif",
	6,"faces_yelling[1].gif",

	7,"food_apricot[1].gif",
	7,"food_biscuit[1].gif",
	7,"food_bread[1].gif",
	7,"food_cake[1].gif",
	7,"food_cheese[1].gif",
	7,"food_cherry[1].gif",
	7,"food_chicken[1].gif",
	7,"food_coconut[1].gif",
	7,"food_fried_egg[1].gif",
	7,"food_grapefruit[1].gif",
	7,"food_halloween[1].gif",
	7,"food_hamburger[1].gif",
	7,"food_lemon[1].gif",
	7,"food_lettuce[1].gif",
	7,"food_orange[1].gif",
	7,"food_peach[1].gif",
	7,"food_pear[1].gif",
	7,"food_pineapple[1].gif",
	7,"food_plum[1].gif",
	7,"food_raspberry[1].gif",
	7,"food_slice[1].gif",
	7,"food_soft-boiled_egg[1].gif",
	7,"food_steak[1].gif",
	7,"food_strawberry[1].gif",
	7,"food_tomato[1].gif",

	8,"objects_alarm[1].gif",
	8,"objects_alarm_clock[1].gif",
	8,"objects_birthday[1].gif",
	8,"objects_bomb[1].gif",
	8,"objects_bulb[1].gif",
	8,"objects_button[1].gif",
	8,"objects_cactus[1].gif",
	8,"objects_cd[1].gif",
	8,"objects_crosswords[1].gif",
	8,"objects_green_light[1].gif",
	8,"objects_grenade[1].gif",
	8,"objects_handle[1].gif",
	8,"objects_headlight[1].gif",
	8,"objects_ice-stick[1].gif",
	8,"objects_internet[1].gif",
	8,"objects_key[1].gif",
	8,"objects_medal[1].gif",
	8,"objects_nappy[1].gif",
	8,"objects_phone[1].gif",
	8,"objects_red_light[1].gif",
	8,"objects_rose[1].gif",
	8,"objects_snowing[1].gif",
	8,"objects_stop[1].gif",
	8,"objects_telephone[1].gif",
	8,"objects_tulip[1].gif",
	8,"objects_washing_machine[1].gif",
	8,"objects_water_drop[1].gif",
	8,"objects_wheel[1].gif",

	9,"airline_pilot.gif",
	9,"air_hostess.gif",
	9,"alien.gif",
	9,"artist.gif",
	9,"astronaut.gif",
	9,"baby.gif",
	9,"baker.gif",
	9,"banker.gif",
	9,"bearded.gif",
	9,"bell_boy.gif",
	9,"beret.gif",
	9,"blue_helmet.gif",
	9,"camouflage.gif",
	9,"centurion.gif",
	9,"chambermaid.gif",
	9,"chauffeur.gif",
	9,"chef.gif",
	9,"chinese.gif",
	9,"clown.gif",
	9,"cowboy.gif",
	9,"deep_sea_diver.gif",
	9,"devil.gif",
	9,"diva.gif",
	9,"diving.gif",
	9,"doctor.gif",
	9,"elegant.gif",
	9,"female.gif",
	9,"fighter_pilot.gif",
	9,"fireman.gif",
	9,"gas_mask.gif",
	9,"general.gif",
	9,"graduate.gif",

	10,"hero.gif",
	10,"joker.gif",
	10,"judge.gif",
	10,"king.gif",
	10,"knight.gif",
	10,"mask.gif",
	10,"miner.gif",
	10,"moustached.gif",
	10,"musketeer.gif",
	10,"nun.gif",
	10,"paparazzi.gif",
	10,"party.gif",
	10,"pirate.gif",
	10,"policeman.gif",
	10,"postman.gif",
	10,"prisoner.gif",
	10,"queen.gif",
	10,"raining.gif",
	10,"rebel.gif",
	10,"republican_guard.gif",
	10,"robot.gif",
	10,"savlour.gif",
	10,"sheriff.gif",
	10,"ships_boy.gif",
	10,"soldier.gif",
	10,"superhero.gif",
	10,"surgeon.gif",
	10,"swimming.gif",
	10,"television_reporter.gif",
	10,"thief.gif",
	10,"vampire.gif",
	10,"wig.gif",
	10,"witch.gif",
	10,"workman.gif",
	10,"yankee.gif",

	11,"sports_badminton.gif",
	11,"sports_basketball.gif",
	11,"sports_cap.gif",
	11,"sports_cross-country_skiing.gif",
	11,"sports_dart-flechettes.gif",
	11,"sports_fencing.gif",
	11,"sports_football.gif",
	11,"sports_formula_one.gif",
	11,"sports_handball.gif",
	11,"sports_hockey.gif",
	11,"sports_horse_riding.gif",
	11,"sports_hot-air_balloon.gif",
	11,"sports_olympic_rings.gif",
	11,"sports_ping_pong.gif",
	11,"sports_polo.gif",
	11,"sports_rugby.gif",
	11,"sports_skateboard.gif",
	11,"sports_skiing.gif",
	11,"sports_snooker.gif",
	11,"sports_sports.gif",
	11,"sports_squash.gif",
	11,"sports_surfing.gif",
	11,"sports_tennis.gif",
	11,"sports_volleyball.gif",
	11,"sports_water_polo.gif",

	12,"planets_aquarius[1].gif",
	12,"planets_cancer[1].gif",
	12,"planets_earth[1].gif",
	12,"planets_gemini[1].gif",
	12,"planets_jupiter[1].gif",
	12,"planets_leo[1].gif",
	12,"planets_libra[1].gif",
	12,"planets_mars[1].gif",
	12,"planets_mercury[1].gif",
	12,"planets_moon[1].gif",
	12,"planets_neptune[1].gif",
	12,"planets_petanque[1].gif",
	12,"planets_pisces[1].gif",
	12,"planets_pluto[1].gif",
	12,"planets_saturn[1].gif",
	12,"planets_scorpio[1].gif",
	12,"planets_taurus[1].gif",
	12,"planets_uranus[1].gif",
	12,"planets_venus[1].gif",
	12,"planets_virgo[1].gif"
);


window.onbeforeunload = tanbih;
function tanbih(){
	if(edit){
		event.returnValue = ed_confirm_exit;
	}
}
