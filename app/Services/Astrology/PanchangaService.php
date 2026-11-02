<?php

namespace App\Services\Astrology;

use Carbon\Carbon;

class PanchangaService
{
    /**
     * 12 Rasis (Zodiac Signs) with multi-language names, lords, mobility, parity & overviews
     */
    public const RASIS = [
        1 => [
            'index' => 1,
            'sanskrit' => 'Mesha',
            'name_en' => 'Aries (Medam / Mesha)',
            'name_ml' => 'മേടം (Medam)',
            'name_ta' => 'மேஷம் (Mesham)',
            'name_hi' => 'मेष (Mesha)',
            'lord_code' => 'Ma',
            'lord' => 'Kuja / Mars (ചൊവ്വ)',
            'symbol' => '♈ Ram',
            'mobility' => 'Chara (Movable)',
            'parity' => 'Ojha (Odd)',
            'element' => ['en' => 'Fire (അഗ്നി)', 'ml' => 'അഗ്നി (Fire)', 'ta' => 'நெருப்பு (Fire)', 'hi' => 'अग्नि (Fire)'],
            'sign_overview' => [
                'en' => 'Governed by Kuja (Mars), Mesha (Medam) natives possess dynamic courage, pioneering leadership, and decisive vitality.',
                'ml' => 'ചൊവ്വയുടെ ആധിപത്യമുള്ള മേടം രാശിക്കാർ നേതൃഗുണവും നിർഭയത്വവും പുതിയ സംരംഭങ്ങൾക്ക് തുടക്കമിടാനുള്ള ധീരതയും ഉള്ളവരാണ്.',
                'ta' => 'செவ்வாய் பகவானின் ஆட்சி பெற்ற மேஷ ராசிக்காரர்கள் முன்னோடித் தன்மையும், வேகமும், எதையும் சாதிக்கும் துணிச்சலும் கொண்டவர்கள்.',
                'hi' => 'मंगल के स्वामित्व वाली मेष राशि के जातक ऊर्जावान, साहसी और नए कार्यों की शुरुआत करने में निपुण होते हैं।',
            ],
        ],
        2 => [
            'index' => 2,
            'sanskrit' => 'Vrushabha',
            'name_en' => 'Taurus (Edavam / Vrushabha)',
            'name_ml' => 'ഇടവം (Edavam)',
            'name_ta' => 'ரிஷபம் (Rishabham)',
            'name_hi' => 'वृषभ (Vrishabha)',
            'lord_code' => 'Ve',
            'lord' => 'Shukra / Venus (ശുക്രൻ)',
            'symbol' => '♉ Bull',
            'mobility' => 'Sthira (Fixed)',
            'parity' => 'Yugma (Even)',
            'element' => ['en' => 'Earth (ഭൂമി)', 'ml' => 'ഭൂമി (Earth)', 'ta' => 'பூமி (Earth)', 'hi' => 'पृथ्वी (Earth)'],
            'sign_overview' => [
                'en' => 'Governed by Shukra (Venus), Vrushabha (Edavam) natives are steadfast, artistic, reliable, and blessed with material prosperity.',
                'ml' => 'ശുക്രന്റെ ആധിപത്യമുള്ള ഇടവം രാശിക്കാർ സ്ഥിരതയുള്ളവരും കലാപ്രിയരും വിശ്വസ്തരും സമ്പത്ത് സ്വരൂപിക്കുന്നതിൽ സമർത്ഥരുമാണ്.',
                'ta' => 'சுக்கிரனின் ஆதிக்கம் பெற்ற ரிஷப ராசிக்காரர்கள் நிதானமானவர்கள், சுகபோகங்களை விரும்புபவர்கள் மற்றும் சொத்துக்களைக் குவிக்கும் ஆற்றல் படைத்தவர்கள்.',
                'hi' => 'शुक्र शासित वृषभ राशि के जातक दृढ़निश्चयी, व्यावहारिक और धन-संपत्ति संचय करने में अत्यंत कुशल होते हैं।',
            ],
        ],
        3 => [
            'index' => 3,
            'sanskrit' => 'Mithuna',
            'name_en' => 'Gemini (Mithunam / Mithuna)',
            'name_ml' => 'മിഥുനം (Mithunam)',
            'name_ta' => 'மிதுனம் (Mithunam)',
            'name_hi' => 'मिथुन (Mithuna)',
            'lord_code' => 'Me',
            'lord' => 'Budha / Mercury (ബുധൻ)',
            'symbol' => '♊ Couple',
            'mobility' => 'Ubhaya (Dual)',
            'parity' => 'Ojha (Odd)',
            'element' => ['en' => 'Air (വായു)', 'ml' => 'വായു (Air)', 'ta' => 'காற்று (Air)', 'hi' => 'वायु (Air)'],
            'sign_overview' => [
                'en' => 'Governed by Budha (Mercury), Mithuna natives are intellectually brilliant, eloquent communicators, and versatile scholars.',
                'ml' => 'ബുധന്റെ ആധിപത്യമുള്ള മിഥുനം രാശിക്കാർ അറിവ് സമ്പാദിക്കുന്നതിലും ആശയവിനിമയത്തിലും സാമർത്ഥ്യം പുലർത്തുന്നവരാണ്.',
                'ta' => 'புதனின் ஆதிக்கம் பெற்ற மிதுன ராசிக்காரர்கள் புத்தி கூர்மையும், சிறந்த சொல்வன்மையும், பன்முகத் திறமையும் கொண்டவர்கள்.',
                'hi' => 'बुध शासित मिथुन राशि के जातक अत्यंत बुद्धिमान, वाकपटु, जिज्ञासु और बहुमुखी प्रतिभा के धनी होते हैं।',
            ],
        ],
        4 => [
            'index' => 4,
            'sanskrit' => 'Karkitaka',
            'name_en' => 'Cancer (Karkidakam / Karkitaka)',
            'name_ml' => 'കർക്കിടകം (Karkidakam)',
            'name_ta' => 'கடகம் (Katakam)',
            'name_hi' => 'कर्क (Karka)',
            'lord_code' => 'Mo',
            'lord' => 'Chandra / Moon (ചന്ദ്രൻ)',
            'symbol' => '♋ Crab',
            'mobility' => 'Chara (Movable)',
            'parity' => 'Yugma (Even)',
            'element' => ['en' => 'Water (ജലം)', 'ml' => 'ജലം (Water)', 'ta' => 'நீர் (Water)', 'hi' => 'जल (Water)'],
            'sign_overview' => [
                'en' => 'Governed by Chandra (Moon), Karkitaka natives are deeply intuitive, compassionate, nurturing, and devoted to family.',
                'ml' => 'ചന്ദ്രന്റെ ആധിപത്യമുള്ള കർക്കിടകം രാശിക്കാർ കുടുംബസ്നേഹികളും ആർദ്രഹൃദയരും അന്തർജ്ഞാനമുള്ളവരുമാണ്.',
                'ta' => 'சந்திரனின் ஆட்சி பெற்ற கடக ராசிக்காரர்கள் பாசமும், ஆழமான உள்ளுணர்வும், குடும்பப் பற்றும் மிகுந்தவர்கள்.',
                'hi' => 'चंद्र शासित कर्क राशि के जातक संवेदनशील, स्नेही, सहृदय और परिवार के प्रति पूर्ण समर्पित होते हैं।',
            ],
        ],
        5 => [
            'index' => 5,
            'sanskrit' => 'Simha',
            'name_en' => 'Leo (Chingam / Simha)',
            'name_ml' => 'ചിങ്ങം (Chingam)',
            'name_ta' => 'சிம்மம் (Simham)',
            'name_hi' => 'सिंह (Simha)',
            'lord_code' => 'Su',
            'lord' => 'Ravi / Sun (സൂര്യൻ)',
            'symbol' => '♌ Lion',
            'mobility' => 'Sthira (Fixed)',
            'parity' => 'Ojha (Odd)',
            'element' => ['en' => 'Fire (അഗ്നി)', 'ml' => 'അഗ്നി (Fire)', 'ta' => 'நெருப்பு (Fire)', 'hi' => 'अग्नि (Fire)'],
            'sign_overview' => [
                'en' => 'Governed by Ravi (Sun), Simha (Chingam) natives possess royal dignity, magnetic authority, and noble generosity.',
                'ml' => 'സൂര്യന്റെ സ്വന്തം രാശിയായ ചിങ്ങത്തിൽ ജനിച്ചവർ രാജകീയ പ്രൗഢിയും ഔദാര്യവും സ്വാഭാവിക അധികാരശക്തിയും ഉള്ളവരാണ്.',
                'ta' => 'சூரியனின் ஆட்சி பெற்ற சிம்ம ராசிக்காரர்கள் கம்பீரமும், தாராள மனமும், ஆளுமைத் திறனும் கொண்டவர்கள்.',
                'hi' => 'सूर्य की अपनी सिंह राशि के जातक राजसी ठाठ-बाट, उदार हृदय और नेतृत्व कौशल के धनी होते हैं।',
            ],
        ],
        6 => [
            'index' => 6,
            'sanskrit' => 'Kanya',
            'name_en' => 'Virgo (Kanni / Kanya)',
            'name_ml' => 'കന്നി (Kanni)',
            'name_ta' => 'கன்னி (Kanni)',
            'name_hi' => 'कन्या (Kanya)',
            'lord_code' => 'Me',
            'lord' => 'Budha / Mercury (ബുധൻ)',
            'symbol' => '♍ Maiden',
            'mobility' => 'Ubhaya (Dual)',
            'parity' => 'Yugma (Even)',
            'element' => ['en' => 'Earth (ഭൂമി)', 'ml' => 'ഭൂമി (Earth)', 'ta' => 'பூமி (Earth)', 'hi' => 'पृथ्वी (Earth)'],
            'sign_overview' => [
                'en' => 'Governed by Budha (Mercury), Kanya (Kanni) natives are analytical, discerning, methodical, and skilled in fine arts and sciences.',
                'ml' => 'ബുധന്റെ ആധിപത്യമുള്ള കന്നി രാശിക്കാർ സൂക്ഷ്മനിരീക്ഷണപാടവവും കാര്യക്ഷമതയും സേവനമനോഭാവവുമുള്ളവരാണ്.',
                'ta' => 'புதனின் ஆட்சி பெற்ற கன்னி ராசிக்காரர்கள் நுணுக்கமான புத்தி, சேவை மனப்பான்மை மற்றும் ஒழுங்குமுறை கொண்டவர்கள்.',
                'hi' => 'बुध शासित कन्या राशि के जातक विश्लेषणात्मक, बारीकियों पर ध्यान देने वाले और सेवाभावी होते हैं।',
            ],
        ],
        7 => [
            'index' => 7,
            'sanskrit' => 'Tula',
            'name_en' => 'Libra (Thulam / Tula)',
            'name_ml' => 'തുലാം (Thulam)',
            'name_ta' => 'துலாம் (Thulam)',
            'name_hi' => 'तुला (Tula)',
            'lord_code' => 'Ve',
            'lord' => 'Shukra / Venus (ശുക്രൻ)',
            'symbol' => '♎ Scales',
            'mobility' => 'Chara (Movable)',
            'parity' => 'Ojha (Odd)',
            'element' => ['en' => 'Air (വായു)', 'ml' => 'വായു (Air)', 'ta' => 'காற்று (Air)', 'hi' => 'वायु (Air)'],
            'sign_overview' => [
                'en' => 'Governed by Shukra (Venus), Tula (Thulam) natives champion balance, justice, diplomacy, and refined harmony.',
                'ml' => 'ശുക്രന്റെ ആധിപത്യമുള്ള തുലാം രാശിക്കാർ നീതിബോധവും സൗന്ദര്യസ്നേഹവും സമാധാനപ്രിയത്വവും ഉള്ളവരാണ്.',
                'ta' => 'சுக்கிரனின் ஆட்சி பெற்ற துலாம் ராசிக்காரர்கள் சமநிலை, அழகுணர்ச்சி, நியாயம் மற்றும் அமைதியை விரும்புபவர்கள்.',
                'hi' => 'शुक्र शासित तुला राशि के जातक संतुलन, न्याय, सौम्यता और शांतिप्रिय जीवन के पक्षधर होते हैं।',
            ],
        ],
        8 => [
            'index' => 8,
            'sanskrit' => 'Vrucchika',
            'name_en' => 'Scorpio (Vrischikam / Vrucchika)',
            'name_ml' => 'വൃശ്ചികം (Vrischikam)',
            'name_ta' => 'விருச்சிகம் (Vrischikam)',
            'name_hi' => 'वृश्चिक (Vrischika)',
            'lord_code' => 'Ma',
            'lord' => 'Kuja / Mars (ചൊവ്വ)',
            'symbol' => '♏ Scorpion',
            'mobility' => 'Sthira (Fixed)',
            'parity' => 'Yugma (Even)',
            'element' => ['en' => 'Water (ജലം)', 'ml' => 'ജലം (Water)', 'ta' => 'நீர் (Water)', 'hi' => 'जल (Water)'],
            'sign_overview' => [
                'en' => 'Governed by Kuja (Mars), Vrucchika (Vrischikam) natives possess deep intuition, resilience, research acumen, and unwavering resolve.',
                'ml' => 'ചൊവ്വയുടെ ആധിപത്യമുള്ള വൃശ്ചികം രാശിക്കാർ ആഴമേറിയ മനക്കരുത്തും നിഗൂഢതയും അചഞ്ചലമായ ലക്ഷ്യബോധവുമുള്ളവരാണ്.',
                'ta' => 'செவ்வாயின் ஆதிக்கம் பெற்ற விருச்சிக ராசிக்காரர்கள் தீவிர மன உறுதி, ஆழ்ந்த உள்ளுணர்வு மற்றும் எதையும் தாங்கும் சக்தி கொண்டவர்கள்.',
                'hi' => 'मंगल शासित वृश्चिक राशि के जातक गहन, साहसी, रहस्यमयी और अटूट संकल्प शक्ति वाले होते हैं।',
            ],
        ],
        9 => [
            'index' => 9,
            'sanskrit' => 'Dhanu',
            'name_en' => 'Sagittarius (Dhanu)',
            'name_ml' => 'ധനു (Dhanu)',
            'name_ta' => 'தனுசு (Thanusu)',
            'name_hi' => 'धनु (Dhanu)',
            'lord_code' => 'Ju',
            'lord' => 'Guru / Jupiter (വ്യാഴം)',
            'symbol' => '♐ Archer',
            'mobility' => 'Ubhaya (Dual)',
            'parity' => 'Ojha (Odd)',
            'element' => ['en' => 'Fire (അഗ്നി)', 'ml' => 'അഗ്നി (Fire)', 'ta' => 'நெருப்பு (Fire)', 'hi' => 'अग्नि (Fire)'],
            'sign_overview' => [
                'en' => 'Governed by Guru (Jupiter), Dhanu natives are righteous, philosophical, optimistic, and guided by higher dharmic wisdom.',
                'ml' => 'വ്യാഴത്തിന്റെ ആധിപത്യമുള്ള ധനു രാശിക്കാർ ജ്ഞാനദാഹികളും സത്യസന്ധരും ശുഭാപ്തിവിശ്വാസമുള്ളവരുമാണ്.',
                'ta' => 'குருவின் ஆட்சி பெற்ற தனுசு ராசிக்காரர்கள் நேர்மை, ஆன்மீக நாட்டம், உயர் லட்சியங்கள் கொண்ட உன்னத மனிதர்கள்.',
                'hi' => 'गुरु शासित धनु राशि के जातक सत्यवादी, आशावादी, दार्शनिक और उच्च आदर्शों वाले होते हैं।',
            ],
        ],
        10 => [
            'index' => 10,
            'sanskrit' => 'Makara',
            'name_en' => 'Capricorn (Makaram / Makara)',
            'name_ml' => 'മകരം (Makaram)',
            'name_ta' => 'மகரம் (Makaram)',
            'name_hi' => 'मकर (Makara)',
            'lord_code' => 'Sa',
            'lord' => 'Shani / Saturn (ശനി)',
            'symbol' => '♑ Makara',
            'mobility' => 'Chara (Movable)',
            'parity' => 'Yugma (Even)',
            'element' => ['en' => 'Earth (ഭൂമി)', 'ml' => 'ഭൂമി (Earth)', 'ta' => 'பூமி (Earth)', 'hi' => 'पृथ्वी (Earth)'],
            'sign_overview' => [
                'en' => 'Governed by Shani (Saturn), Makara natives are disciplined, persevering, practical, and destined for enduring achievement.',
                'ml' => 'ശനിയുടെ ആധിപത്യമുള്ള മകരം രാശിക്കാർ അച്ചടക്കവും ക്ഷമയും കഠിനാധ്വാനവും കൊണ്ട് ഉന്നത വിജയങ്ങൾ കൈവരിക്കുന്നവരാണ്.',
                'ta' => 'சனியின் ஆட்சி பெற்ற மகர ராசிக்காரர்கள் விடாமுயற்சி, பொறுமை மற்றும் உயர்ந்த இலக்குகளை அடையும் வல்லமை கொண்டவர்கள்.',
                'hi' => 'शनि शासित मकर राशि के जातक अनुशासित, महत्वाकांक्षी और कठिन परिश्रम से शिखर छूने वाले होते हैं।',
            ],
        ],
        11 => [
            'index' => 11,
            'sanskrit' => 'Kumbha',
            'name_en' => 'Aquarius (Kumbham / Kumbha)',
            'name_ml' => 'കുംഭം (Kumbham)',
            'name_ta' => 'கும்பம் (Kumbham)',
            'name_hi' => 'कुंभ (Kumbha)',
            'lord_code' => 'Sa',
            'lord' => 'Shani / Saturn (ശനി)',
            'symbol' => '♒ Pot-Bearer',
            'mobility' => 'Sthira (Fixed)',
            'parity' => 'Ojha (Odd)',
            'element' => ['en' => 'Air (വായു)', 'ml' => 'വായു (Air)', 'ta' => 'காற்று (Air)', 'hi' => 'वायु (Air)'],
            'sign_overview' => [
                'en' => 'Governed by Shani (Saturn), Kumbha natives are deep thinkers, humanitarians, and original innovators.',
                'ml' => 'ശനിയുടെ ആധിപത്യമുള്ള കുംഭം രാശിക്കാർ മാനവികതയും വേറിട്ട ചിന്താരീതികളും സമൂഹത്തിൽ മാറ്റങ്ങൾ കൊണ്ടുവരാനുള്ള ആഗ്രഹവുമുള്ളവരാണ്.',
                'ta' => 'சனியின் ஆட்சி பெற்ற கும்ப ராசிக்காரர்கள் முற்போக்கு சிந்தனை, மனிதநேயம் மற்றும் புதுமைகளைப் புகுத்தும் ஆர்வம் கொண்டவர்கள்.',
                'hi' => 'शनि शासित कुंभ राशि के जातक मानवतावादी, मौलिक विचारक और समाज सुधारक दृष्टि वाले होते हैं।',
            ],
        ],
        12 => [
            'index' => 12,
            'sanskrit' => 'Meena',
            'name_en' => 'Pisces (Meenam / Meena)',
            'name_ml' => 'മീനം (Meenam)',
            'name_ta' => 'மீனம் (Meenam)',
            'name_hi' => 'मीन (Meena)',
            'lord_code' => 'Ju',
            'lord' => 'Guru / Jupiter (വ്യാഴം)',
            'symbol' => '♓ Two Fishes',
            'mobility' => 'Ubhaya (Dual)',
            'parity' => 'Yugma (Even)',
            'element' => ['en' => 'Water (ജലം)', 'ml' => 'ജലം (Water)', 'ta' => 'நீர் (Water)', 'hi' => 'जल (Water)'],
            'sign_overview' => [
                'en' => 'Governed by Guru (Jupiter), Meena natives are spiritually elevated, intuitive, compassionate, and wise.',
                'ml' => 'വ്യാഴത്തിന്റെ ആധിപത്യമുള്ള മീനം രാശിക്കാർ ദയാലുക്കളും ഭാവനാസമ്പന്നരും ആത്മീയ ചിന്താഗതിക്കാരുമാണ്.',
                'ta' => 'குருவின் ஆட்சி பெற்ற மீன ராசிக்காரர்கள் கருணை, கற்பனைத் திறன் மற்றும் ஆன்மீக பக்தி நிறைந்தவர்கள்.',
                'hi' => 'गुरु शासित मीन राशि के जातक दयालु, परोपकारी, कल्पनाशील और आध्यात्मिक स्वभाव वाले होते हैं।',
            ],
        ],
    ];

    /**
     * Complete 27 Nakshatras with Archetype Lookup Table from Vedanga Jyothisham Pages 144–145
     * (Deity, Element/Bhoota, Gana, Yoni/Gender, Animal/Mrugam, Bird/Pakshi, Tree/Vruksham)
     */
    public const NAKSHATRAS = [
        1 => ['index' => 1, 'name_en' => 'Ashwini (Aswathi)', 'name_ml' => 'അശ്വതി (Ashwini)', 'name_ta' => 'அஸ்வினி', 'name_hi' => 'अश्विनी', 'lord_code' => 'Ke', 'lord' => 'Ketu (കേതു)', 'deity' => 'Ashwini Kumaras (അശ്വിനീദേവകൾ)', 'element' => 'Earth (ഭൂമി)', 'gana' => 'Deva (ദേവഗണം)', 'yoni' => 'Purusha (പുരുഷയോനി)', 'animal' => 'Male Horse (ആൺകുതിര)', 'bird' => 'Wild Eagle (പുള്ള്)', 'tree' => 'Strychnine / Kanjiram (കാഞ്ഞിരം)'],
        2 => ['index' => 2, 'name_en' => 'Bharani', 'name_ml' => 'ഭരണി (Bharani)', 'name_ta' => 'பரணி', 'name_hi' => 'भरणी', 'lord_code' => 'Ve', 'lord' => 'Shukra (ശുക്രൻ)', 'deity' => 'Yama (യമൻ)', 'element' => 'Earth (ഭൂമി)', 'gana' => 'Manushya (മനുഷ്യഗണം)', 'yoni' => 'Purusha (പുരുഷയോനി)', 'animal' => 'Male Elephant (ആൺആന)', 'bird' => 'Crow (കാക്ക)', 'tree' => 'Indian Gooseberry / Nelli (നെല്ലി)'],
        3 => ['index' => 3, 'name_en' => 'Krittika (Karthika)', 'name_ml' => 'കാർത്തിക (Krittika)', 'name_ta' => 'கார்த்திகை', 'name_hi' => 'कृत्तिका', 'lord_code' => 'Su', 'lord' => 'Ravi (സൂര്യൻ)', 'deity' => 'Agni (അഗ്നി)', 'element' => 'Earth (ഭൂമി)', 'gana' => 'Asura (അസുരഗണം)', 'yoni' => 'Stree (സ്ത്രീയോനി)', 'animal' => 'Female Sheep (പെണ്ണാട്)', 'bird' => 'Peacock (മയിൽ)', 'tree' => 'Cluster Fig / Athi (അത്തി)'],
        4 => ['index' => 4, 'name_en' => 'Rohini', 'name_ml' => 'രോഹിണി (Rohini)', 'name_ta' => 'ரோகிணி', 'name_hi' => 'रोहिणी', 'lord_code' => 'Mo', 'lord' => 'Chandra (ചന്ദ്രൻ)', 'deity' => 'Brahma (ബ്രഹ്മാവ്)', 'element' => 'Earth (ഭൂമി)', 'gana' => 'Manushya (മനുഷ്യഗണം)', 'yoni' => 'Purusha (പുരുഷയോനി)', 'animal' => 'Male Serpent (ആൺപാമ്പ്)', 'bird' => 'Barn Owl (പുല്ലുങ്കൽ / മൂങ്ങ)', 'tree' => 'Jamun / Njaval (ഞാവൽ)'],
        5 => ['index' => 5, 'name_en' => 'Mrigashira (Makayiram)', 'name_ml' => 'മകയിരം (Mrigashira)', 'name_ta' => 'மிருகசீரிடம்', 'name_hi' => 'मृगशिरा', 'lord_code' => 'Ma', 'lord' => 'Kuja (ചൊവ്വ)', 'deity' => 'Chandra (ചന്ദ്രൻ)', 'element' => 'Earth (ഭൂമി)', 'gana' => 'Deva (ദേവഗണം)', 'yoni' => 'Napumsaka / Stree (നപുംസകം)', 'animal' => 'Female Serpent (പെൺപാമ്പ്)', 'bird' => 'Hen (പിടക്കോഴി)', 'tree' => 'Cutch Tree / Karingali (കരിങ്ങാലി)'],
        6 => ['index' => 6, 'name_en' => 'Ardra (Thiruvathira)', 'name_ml' => 'തിരുവാതിര (Ardra)', 'name_ta' => 'திருவாதிரை', 'name_hi' => 'आर्द्रा', 'lord_code' => 'Ra', 'lord' => 'Rahu (രാഹു)', 'deity' => 'Rudra / Shiva (ശിവൻ)', 'element' => 'Water (ജലം)', 'gana' => 'Manushya (മനുഷ്യഗണം)', 'yoni' => 'Stree (സ്ത്രീയോനി)', 'animal' => 'Male Dog (ആൺനായ)', 'bird' => 'Chakora / Uppan (ഉപ്പൻ)', 'tree' => 'Red Sandalwood /Karimaram (കരിമരം)'],
        7 => ['index' => 7, 'name_en' => 'Punarvasu (Punartham)', 'name_ml' => 'പുണർതം (Punarvasu)', 'name_ta' => 'புனர்பூசம்', 'name_hi' => 'पुनर्वसु', 'lord_code' => 'Ju', 'lord' => 'Guru (വ്യാഴം)', 'deity' => 'Aditi (അദിതി)', 'element' => 'Water (ജലം)', 'gana' => 'Deva (ദേവഗണം)', 'yoni' => 'Purusha (പുരുഷയോനി)', 'animal' => 'Female Cat (പെൺപൂച്ച)', 'bird' => 'Swan (അരയന്നം)', 'tree' => 'Bamboo / Mula (മുള)'],
        8 => ['index' => 8, 'name_en' => 'Pushya (Pooyam)', 'name_ml' => 'പൂയം (Pushya)', 'name_ta' => 'பூசம்', 'name_hi' => 'पुष्य', 'lord_code' => 'Sa', 'lord' => 'Shani (ശനി)', 'deity' => 'Brihaspati (ബൃഹസ്പതി)', 'element' => 'Water (ജലം)', 'gana' => 'Deva (ദേവഗണം)', 'yoni' => 'Purusha (പുരുഷയോനി)', 'animal' => 'Male Sheep (ആട്ടുകൊറ്റൻ)', 'bird' => 'Water Crow (നീർക്കാക്ക)', 'tree' => 'Sacred Fig / Arayal (അരയാൽ)'],
        9 => ['index' => 9, 'name_en' => 'Ashlesha (Ayilyam)', 'name_ml' => 'ആയില്യം (Ashlesha)', 'name_ta' => 'ஆயில்യം', 'name_hi' => 'आश्लेषा', 'lord_code' => 'Me', 'lord' => 'Budha (ബുധൻ)', 'deity' => 'Serpent Gods / Nagas (സർപ്പങ്ങൾ)', 'element' => 'Water (ജലം)', 'gana' => 'Asura (അസുരഗണം)', 'yoni' => 'Stree (സ്ത്രീയോനി)', 'animal' => 'Male Cat (കണ്ടൻപൂച്ച)', 'bird' => 'Small Kite (ചെമ്പോത്ത്)', 'tree' => 'Alexandrian Laurel / Punna (പുന്ന)'],
        10 => ['index' => 10, 'name_en' => 'Magha (Makam)', 'name_ml' => 'മകം (Magha)', 'name_ta' => 'மகம்', 'name_hi' => 'मघा', 'lord_code' => 'Ke', 'lord' => 'Ketu (കേതു)', 'deity' => 'Pitris (പിതൃക്കൾ)', 'element' => 'Water (ജലം)', 'gana' => 'Asura (അസുരഗണം)', 'yoni' => 'Stree (സ്ത്രീയോനി)', 'animal' => 'Male Rat (ആൺഎലി)', 'bird' => 'Eagle (കഴുകൻ)', 'tree' => 'Banyan Tree / Peral (പേരാൽ)'],
        11 => ['index' => 11, 'name_en' => 'Purva Phalguni (Pooram)', 'name_ml' => 'പൂരം (Pooram)', 'name_ta' => 'பூரம்', 'name_hi' => 'पूर्वाफाल्गुनी', 'lord_code' => 'Ve', 'lord' => 'Shukra (ശുക്രൻ)', 'deity' => 'Aryama / Bhaga (ആര്യമാവ്)', 'element' => 'Water (ജലം)', 'gana' => 'Manushya (മനുഷ്യഗണം)', 'yoni' => 'Stree (സ്ത്രീയോനി)', 'animal' => 'Female Rat (പെൺഎലി)', 'bird' => 'Female Eagle (പെൺകഴുകൻ)', 'tree' => 'Flame of the Forest / Plashu (പ്ലാശ്)'],
        12 => ['index' => 12, 'name_en' => 'Uttara Phalguni (Uthram)', 'name_ml' => 'ഉത്രം (Uthram)', 'name_ta' => 'உத்திரம்', 'name_hi' => 'उत्तराफाल्गुनी', 'lord_code' => 'Su', 'lord' => 'Ravi (സൂര്യൻ)', 'deity' => 'Bhaga (ഭഗൻ)', 'element' => 'Fire (അഗ്നി)', 'gana' => 'Manushya (മനുഷ്യഗണം)', 'yoni' => 'Purusha (പുരുഷയോനി)', 'animal' => 'Male Cow / Bull (കാള)', 'bird' => 'Vulture / Marappatti (മരപ്പട്ടി / പരുന്ത്)', 'tree' => 'Indian Fig / Ithi (ഇത്തി)'],
        13 => ['index' => 13, 'name_en' => 'Hasta (Atham)', 'name_ml' => 'അത്തം (Atham)', 'name_ta' => 'ஹஸ்தம்', 'name_hi' => 'हस्त', 'lord_code' => 'Mo', 'lord' => 'Chandra (ചന്ദ്രൻ)', 'deity' => 'Savita / Surya (ആദിത്യൻ)', 'element' => 'Fire (അഗ്നി)', 'gana' => 'Deva (ദേവഗണം)', 'yoni' => 'Purusha (പുരുഷയോനി)', 'animal' => 'Female Buffalo (എരുമ)', 'bird' => 'Kite (പരുന്ത്)', 'tree' => 'Hog Plum / Ambazham (അമ്പഴം)'],
        14 => ['index' => 14, 'name_en' => 'Chitra (Chithira)', 'name_ml' => 'ചിത്തിര (Chithira)', 'name_ta' => 'சித்திரை', 'name_hi' => 'चित्रा', 'lord_code' => 'Ma', 'lord' => 'Kuja (ചൊവ്വ)', 'deity' => 'Tvashtar / Vishwakarma (വിശ്വകർമ്മാവ്)', 'element' => 'Fire (അഗ്നി)', 'gana' => 'Asura (അസുരഗണം)', 'yoni' => 'Stree (സ്ത്രീയോനി)', 'animal' => 'Male Tiger (ആൺപുലി)', 'bird' => 'Woodpecker (മരംകൊത്തി)', 'tree' => 'Bael Tree / Koovalam (കൂവളം)'],
        15 => ['index' => 15, 'name_en' => 'Swati (Chothi)', 'name_ml' => 'ചോതി (Chothi)', 'name_ta' => 'சுவாதி', 'name_hi' => 'स्वाति', 'lord_code' => 'Ra', 'lord' => 'Rahu (രാഹു)', 'deity' => 'Vayu (വായു)', 'element' => 'Fire (അഗ്നി)', 'gana' => 'Deva (ദേവഗണം)', 'yoni' => 'Stree (സ്ത്രീയോനി)', 'animal' => 'Male Buffalo (പോത്ത്)', 'bird' => 'Honeybee (തേനീച്ച)', 'tree' => 'Arjuna Tree / Neermaruthu (നീർമരുത്)'],
        16 => ['index' => 16, 'name_en' => 'Vishakha (Vishakham)', 'name_ml' => 'വിശാഖം (Vishakham)', 'name_ta' => 'விசாகம்', 'name_hi' => 'विशाखा', 'lord_code' => 'Ju', 'lord' => 'Guru (വ്യാഴം)', 'deity' => 'Indragni (ഇന്ദ്രാഗ്നി)', 'element' => 'Fire (അഗ്നി)', 'gana' => 'Asura (അസുരഗണം)', 'yoni' => 'Stree (സ്ത്രീയോനി)', 'animal' => 'Female Tiger (പെൺപുലി)', 'bird' => 'Red Tailorbird (ചെങ്കൊക്കൻ)', 'tree' => 'Governor\'s Plum / Vayyankathavu (വയ്യങ്കതവ്)'],
        17 => ['index' => 17, 'name_en' => 'Anuradha (Anizham)', 'name_ml' => 'അനിഴം (Anizham)', 'name_ta' => 'அனுஷம்', 'name_hi' => 'अनुराधा', 'lord_code' => 'Sa', 'lord' => 'Shani (ശനി)', 'deity' => 'Mitra (മിത്രൻ)', 'element' => 'Fire (അഗ്നി)', 'gana' => 'Deva (ദേവഗണം)', 'yoni' => 'Stree (സ്ത്രീയോനി)', 'animal' => 'Female Deer (പെൺമാൻ)', 'bird' => 'Nightingale (വാനമ്പാടി)', 'tree' => 'Bullet Wood / Elanji (ഇലഞ്ഞി)'],
        18 => ['index' => 18, 'name_en' => 'Jyeshta (Thrikketta)', 'name_ml' => 'തൃക്കേട്ട (Thrikketta)', 'name_ta' => 'கேட்டை', 'name_hi' => 'ज्येष्ठा', 'lord_code' => 'Me', 'lord' => 'Budha (ബുധൻ)', 'deity' => 'Indra (ഇന്ദ്രൻ)', 'element' => 'Air (വായു)', 'gana' => 'Asura (അസുരഗണം)', 'yoni' => 'Purusha (പുരുഷയോനി)', 'animal' => 'Male Deer (കലമാൻ)', 'bird' => 'Brahminy Kite (ചക്രവാകം)', 'tree' => 'Vetiver / Vetti (വെട്ടി)'],
        19 => ['index' => 19, 'name_en' => 'Mula (Moolam)', 'name_ml' => 'മൂലം (Moolam)', 'name_ta' => 'மூலம்', 'name_hi' => 'मूल', 'lord_code' => 'Ke', 'lord' => 'Ketu (കേതു)', 'deity' => 'Nirriti (നിര്യതി / അസുരൻ)', 'element' => 'Air (വായു)', 'gana' => 'Asura (അസുരഗണം)', 'yoni' => 'Napumsaka (നപുംസകം)', 'animal' => 'Female Dog (പെൺനായ)', 'bird' => 'White Vulture (വെളുത്ത പരുന്ത്)', 'tree' => 'White Dammar /ambana (പയിന)'],
        20 => ['index' => 20, 'name_en' => 'Purva Ashadha (Pooradam)', 'name_ml' => 'പൂരാടം (Pooradam)', 'name_ta' => 'பூராடம்', 'name_hi' => 'पूर्वाषाढ़ा', 'lord_code' => 'Ve', 'lord' => 'Shukra (ശുക്രൻ)', 'deity' => 'Apah / Water (ജലം)', 'element' => 'Air (വായു)', 'gana' => 'Manushya (മനുഷ്യഗണം)', 'yoni' => 'Purusha (പുരുഷയോനി)', 'animal' => 'Male Monkey (ആൺകുരങ്ങ്)', 'bird' => 'Francolin (കോഴി)', 'tree' => 'Rattan Cane / Vanchi (വഞ്ചി)'],
        21 => ['index' => 21, 'name_en' => 'Uttara Ashadha (Uthradam)', 'name_ml' => 'ഉത്രാടം (Uthradam)', 'name_ta' => 'உத்திராடம்', 'name_hi' => 'उत्तराषाढ़ा', 'lord_code' => 'Su', 'lord' => 'Ravi (സൂര്യൻ)', 'deity' => 'Vishvedevas (വിശ്വദേവകൾ)', 'element' => 'Air (വായു)', 'gana' => 'Manushya (മനുഷ്യഗണം)', 'yoni' => 'Purusha (പുരുഷയോനി)', 'animal' => 'Male Mongoose (ആൺകീരി)', 'bird' => 'Hornet / വേഴാമ്പൽ', 'tree' => 'Jackfruit Tree / Plavu (പ്ലാവ്)'],
        22 => ['index' => 22, 'name_en' => 'Shravana (Thiruvonam)', 'name_ml' => 'തിരുവോണം (Thiruvonam)', 'name_ta' => 'திருவோணம்', 'name_hi' => 'श्रवण', 'lord_code' => 'Mo', 'lord' => 'Chandra (ചന്ദ്രൻ)', 'deity' => 'Lord Vishnu (വിഷ്ണു)', 'element' => 'Air (വായു)', 'gana' => 'Deva (ദേവഗണം)', 'yoni' => 'Purusha (പുരുഷയോനി)', 'animal' => 'Female Monkey (പെൺകുരങ്ങ്)', 'bird' => 'Barn Owl (മൂങ്ങ)', 'tree' => 'Crown Flower / Erukku (എരിക്ക്)'],
        23 => ['index' => 23, 'name_en' => 'Dhanishta (Avittam)', 'name_ml' => 'അവിട്ടം (Avittam)', 'name_ta' => 'அவிட்டம்', 'name_hi' => 'धनिष्ठा', 'lord_code' => 'Ma', 'lord' => 'Kuja (ചൊവ്വ)', 'deity' => 'Ashta Vasus (വസുക്കൾ)', 'element' => 'Air (വായു)', 'gana' => 'Asura (അസുരഗണം)', 'yoni' => 'Stree (സ്ത്രീയോനി)', 'animal' => 'Female Lion (പെൺസിംഹം)', 'bird' => 'Golden Oriole (മഞ്ഞക്കിളി)', 'tree' => 'Prosopis / Vanni (വന്നി)'],
        24 => ['index' => 24, 'name_en' => 'Shatabhishak (Chathayam)', 'name_ml' => 'ചതയം (Chathayam)', 'name_ta' => 'சதயம்', 'name_hi' => 'शतभिषा', 'lord_code' => 'Ra', 'lord' => 'Rahu (രാഹു)', 'deity' => 'Varuna (വരുണൻ)', 'element' => 'Ether / Sky (ആകാശം)', 'gana' => 'Asura (അസുരഗണം)', 'yoni' => 'Napumsaka (നപുംസകം)', 'animal' => 'Female Horse (പെൺകുതിര)', 'bird' => 'Raven (കാട്ടു കാക്ക)', 'tree' => 'Kadamba (കടമ്പ്)'],
        25 => ['index' => 25, 'name_en' => 'Purva Bhadrapada (Poororuttathi)', 'name_ml' => 'പൂരുരുട്ടാതി (Poororuttathi)', 'name_ta' => 'பூரட்டாதி', 'name_hi' => 'पूर्वाभाद्रपद', 'lord_code' => 'Ju', 'lord' => 'Guru (വ്യാഴം)', 'deity' => 'Ajaikapada (അജൈകപാദ്)', 'element' => 'Ether / Sky (ആകാശം)', 'gana' => 'Manushya (മനുഷ്യഗണം)', 'yoni' => 'Purusha (പുരുഷയോനി)', 'animal' => 'Male Lion (ആൺസിംഹം)', 'bird' => 'Partridge (മയിൽ / ചകോരം)', 'tree' => 'Mango Tree / Thengu (തേന്മാവ്)'],
        26 => ['index' => 26, 'name_en' => 'Uttara Bhadrapada (Uthrattathi)', 'name_ml' => 'ഉത്രട്ടാതി (Uthrattathi)', 'name_ta' => 'உத்திரட்டாதி', 'name_hi' => 'उत्तराभाद्रपद', 'lord_code' => 'Sa', 'lord' => 'Shani (ശനി)', 'deity' => 'Ahirbudhnya (അഹിർബുധ്നി)', 'element' => 'Ether / Sky (ആകാശം)', 'gana' => 'Manushya (മനുഷ്യഗണം)', 'yoni' => 'Purusha (പുരുഷയോനി)', 'animal' => 'Female Cow (പശു)', 'bird' => 'Koil (കുയിൽ)', 'tree' => 'Palmyra / Karimpana (കരിമ്പന)'],
        27 => ['index' => 27, 'name_en' => 'Revati (Revathi)', 'name_ml' => 'രേവതി (Revathi)', 'name_ta' => 'ரேவதி', 'name_hi' => 'रेवती', 'lord_code' => 'Me', 'lord' => 'Budha (ബുധൻ)', 'deity' => 'Pushan (പൂഷാവ്)', 'element' => 'Ether / Sky (ആകാശം)', 'gana' => 'Deva (ദേവഗണം)', 'yoni' => 'Stree (സ്ത്രീയോനി)', 'animal' => 'Female Elephant (പിടിയാന)', 'bird' => 'Peafowl (മയിൽ)', 'tree' => 'Mahua Tree / Ilippa (ഇലിപ്പ)'],
    ];

    /**
     * 27 Nityayogas (Vedanga Jyothisham Page 21)
     */
    public const NITYAYOGAS = [
        1 => ['en' => 'Vishkambha', 'ml' => 'വിഷ്കംഭം (Vishkambha)', 'ta' => 'விஷ்கம்பம்', 'hi' => 'विष्कम्भ'],
        2 => ['en' => 'Preeti', 'ml' => 'പ്രീതി (Preeti)', 'ta' => 'பிரீதி', 'hi' => 'प्रीति'],
        3 => ['en' => 'Ayushman', 'ml' => 'ആയുഷ്മാൻ (Ayushman)', 'ta' => 'ஆயுஷ்மான்', 'hi' => 'आयुष्मान'],
        4 => ['en' => 'Saubhagya', 'ml' => 'സൗഭാഗ്യം (Saubhagya)', 'ta' => 'சௌபாக்கியம்', 'hi' => 'सौभाग्य'],
        5 => ['en' => 'Shobhana', 'ml' => 'ശോഭനം (Shobhana)', 'ta' => 'சோபனம்', 'hi' => 'शोभन'],
        6 => ['en' => 'Atiganda', 'ml' => 'അതിഗണ്ഡം (Atiganda)', 'ta' => 'அதிகண்டம்', 'hi' => 'अतिगण्ड'],
        7 => ['en' => 'Sukarma', 'ml' => 'സുകർമ്മം (Sukarma)', 'ta' => 'சுகர்மம்', 'hi' => 'सुकर्मा'],
        8 => ['en' => 'Dhruti', 'ml' => 'ധൃതി (Dhruti)', 'ta' => 'திருதி', 'hi' => 'धृति'],
        9 => ['en' => 'Shoola', 'ml' => 'ശൂലം (Shoola)', 'ta' => 'சூலம்', 'hi' => 'शूल'],
        10 => ['en' => 'Ganda', 'ml' => 'ഗണ്ഡം (Ganda)', 'ta' => 'கண்டம்', 'hi' => 'गण्ड'],
        11 => ['en' => 'Vruddhi', 'ml' => 'വൃദ്ധി (Vruddhi)', 'ta' => 'விருத்தி', 'hi' => 'वृद्धि'],
        12 => ['en' => 'Dhruva', 'ml' => 'ധ്രുവം (Dhruva)', 'ta' => 'துருவம்', 'hi' => 'ध्रुव'],
        13 => ['en' => 'Vyaghata', 'ml' => 'വ്യാഘാതം (Vyaghata)', 'ta' => 'வியாகாதம்', 'hi' => 'व्याघात'],
        14 => ['en' => 'Harshana', 'ml' => 'ഹർഷണം (Harshana)', 'ta' => 'ஹர்ஷணம்', 'hi' => 'हर्षण'],
        15 => ['en' => 'Vajra', 'ml' => 'വജ്രം (Vajra)', 'ta' => 'வஜ்ரம்', 'hi' => 'वज्र'],
        16 => ['en' => 'Siddhi', 'ml' => 'സിദ്ധി (Siddhi)', 'ta' => 'சித்தி', 'hi' => 'सिद्धि'],
        17 => ['en' => 'Vyatipata', 'ml' => 'വ്യതീപാതം (Vyatipata)', 'ta' => 'வியதீபாதம்', 'hi' => 'व्यतीपात'],
        18 => ['en' => 'Variyan', 'ml' => 'വരീയാൻ (Variyan)', 'ta' => 'வரியான்', 'hi' => 'वरीयान'],
        19 => ['en' => 'Parigha', 'ml' => 'പരിഘം (Parigha)', 'ta' => 'பரிகம்', 'hi' => 'परिघ'],
        20 => ['en' => 'Shiva', 'ml' => 'ശിവം (Shiva)', 'ta' => 'சிவம்', 'hi' => 'शिव'],
        21 => ['en' => 'Siddha', 'ml' => 'സിദ്ധം (Siddha)', 'ta' => 'சித்தம்', 'hi' => 'सिद्ध'],
        22 => ['en' => 'Sadhya', 'ml' => 'സാധ്യം (Sadhya)', 'ta' => 'சாத்தியம்', 'hi' => 'साध्य'],
        23 => ['en' => 'Shubha', 'ml' => 'ശുഭം (Shubha)', 'ta' => 'சுபம்', 'hi' => 'शुभ'],
        24 => ['en' => 'Shukla (Subhra)', 'ml' => 'ശുഭ്രം / ശുക്ലം (Shukla)', 'ta' => 'சுப்பிரம்', 'hi' => 'शुक्ल'],
        25 => ['en' => 'Brahma', 'ml' => 'ബ്രഹ്മം (Brahma)', 'ta' => 'பிரம்மம்', 'hi' => 'ब्रह्म'],
        26 => ['en' => 'Mahendra', 'ml' => 'മഹേന്ദ്രം (Mahendra)', 'ta' => 'மகேந்திரம்', 'hi' => 'ऐन्द्र / महेन्द्र'],
        27 => ['en' => 'Vaidhruti', 'ml' => 'വൈധൃതി (Vaidhruti)', 'ta' => 'வைதிருதி', 'hi' => 'वैधृति'],
    ];

    /**
     * Compute complete Panchanga (Surya Rasi, Chandra Rasi, Nakshatra, Tithi, Nityayoga, Karana, Mulank, Bhagyank)
     */
    public function calculatePanchanga(float $sunLng, float $moonLng, Carbon $birthDate): array
    {
        $sunRasiIdx = (int) floor($sunLng / 30.0) + 1;
        $moonRasiIdx = (int) floor($moonLng / 30.0) + 1;

        $solarSign = self::RASIS[$sunRasiIdx] ?? self::RASIS[1];
        $solarSign['malayalam_day'] = (int) floor(fmod($sunLng, 30.0)) + 1;

        $chandraSign = self::RASIS[$moonRasiIdx] ?? self::RASIS[1];

        // Nakshatra & Pada of Moon
        $nakSpan = 360.0 / 27.0; // 13.33333333°
        $nakIdx = (int) floor($moonLng / $nakSpan) + 1;
        $nakIdx = max(1, min(27, $nakIdx));
        $degInNak = fmod($moonLng, $nakSpan);
        $pada = (int) floor($degInNak / ($nakSpan / 4.0)) + 1;
        $pada = max(1, min(4, $pada));

        $nakshatra = self::NAKSHATRAS[$nakIdx];
        $nakshatra['pada'] = $pada;
        $nakshatra['degrees_elapsed'] = round($degInNak, 4);
        $nakshatra['degrees_remaining'] = round($nakSpan - $degInNak, 4);

        // Tithi & Paksha
        $delta = fmod($moonLng - $sunLng + 360.0, 360.0);
        $tithiIndex = (int) floor($delta / 12.0) + 1; // 1..30
        $tithiIndex = max(1, min(30, $tithiIndex));
        $tithiInfo = $this->getTithiDetails($tithiIndex);

        // Nityayoga (Page 21)
        $sigma = fmod($moonLng + $sunLng, 360.0);
        $yogaIndex = (int) floor($sigma / $nakSpan) + 1; // 1..27
        $yogaIndex = max(1, min(27, $yogaIndex));
        $nityayoga = self::NITYAYOGAS[$yogaIndex];
        $nityayoga['index'] = $yogaIndex;

        // Karana (Pages 20–21)
        $karanaIndex = (int) floor($delta / 6.0) + 1; // 1..60
        $karanaIndex = max(1, min(60, $karanaIndex));
        $karana = $this->getKaranaDetails($karanaIndex);

        // Numerology (Mulank & Bhagyank)
        $day = $birthDate->day;
        $month = $birthDate->month;
        $year = $birthDate->year;
        $mulank = $this->reduceToSingleDigit($day);
        $fullDigits = str_split(sprintf('%02d%02d%04d', $day, $month, $year));
        $bhagyank = $this->reduceToSingleDigit(array_sum(array_map('intval', $fullDigits)));

        return [
            'solar_sign' => $solarSign,
            'chandra_sign' => $chandraSign,
            'nakshatra' => $nakshatra,
            'tithi' => $tithiInfo,
            'nityayoga' => $nityayoga,
            'karana' => $karana,
            'mulank' => $mulank,
            'bhagyank' => $bhagyank,
        ];
    }

    /**
     * Tithi & Pakshabala of Moon (Vedanga Jyothisham Page 39)
     */
    public function getTithiDetails(int $tithiIndex): array
    {
        $names = [
            1 => ['en' => 'Prathama', 'ml' => 'പ്രഥമ'],
            2 => ['en' => 'Dwitiya', 'ml' => 'ദ്വിതീയ'],
            3 => ['en' => 'Tritiya', 'ml' => 'തൃതീയ'],
            4 => ['en' => 'Chaturthi', 'ml' => 'ചതുർത്ഥി'],
            5 => ['en' => 'Panchami', 'ml' => 'പഞ്ചമി'],
            6 => ['en' => 'Shashti', 'ml' => 'ഷഷ്ഠി'],
            7 => ['en' => 'Saptami', 'ml' => 'സപ്തമി'],
            8 => ['en' => 'Ashtami', 'ml' => 'അഷ്ടമി'],
            9 => ['en' => 'Navami', 'ml' => 'നവമി'],
            10 => ['en' => 'Dashami', 'ml' => 'ദശമി'],
            11 => ['en' => 'Ekadashi', 'ml' => 'ഏകാദശി'],
            12 => ['en' => 'Dwadashi', 'ml' => 'ദ്വാദശി'],
            13 => ['en' => 'Trayodashi', 'ml' => 'ത്രയോദശി'],
            14 => ['en' => 'Chaturdashi', 'ml' => 'ചതുർദ്ദശി'],
            15 => ['en' => 'Pournami (Full Moon)', 'ml' => 'പൗർണ്ണമി (വെളുത്തവാവ്)'],
        ];

        $isShukla = $tithiIndex <= 15;
        $pakshaEn = $isShukla ? 'Shukla Paksha (Waxing)' : 'Krishna Paksha (Waning)';
        $pakshaMl = $isShukla ? 'ശുക്ലപക്ഷം (വെളുത്തപക്ഷം)' : 'കൃഷ്ണപക്ഷം (കറുത്തപക്ഷം)';

        if ($tithiIndex === 30) {
            $tithiNameEn = 'Amavasi (New Moon)';
            $tithiNameMl = 'അമാവാസി (കറുത്തവാവ്)';
        } else {
            $numInPaksha = $isShukla ? $tithiIndex : ($tithiIndex - 15);
            $tithiNameEn = $names[$numInPaksha]['en'];
            $tithiNameMl = $names[$numInPaksha]['ml'];
        }

        // Pakshabala of Moon (Page 39):
        // Strong: Shukla Ekadashi (11) to Krishna Panchami (20)
        // Medium: Shukla Prathama (1) to Shukla Dashami (10)
        // Weak: Krishna Shashti (21) to Amavasi (30)
        if ($tithiIndex >= 11 && $tithiIndex <= 20) {
            $pakshabala = 'Strong (പൂർണ്ണബലം)';
        } elseif ($tithiIndex >= 1 && $tithiIndex <= 10) {
            $pakshabala = 'Medium (മധ്യമബലം)';
        } else {
            $pakshabala = 'Weak (ക്ഷീണചന്ദ്രൻ / ബലക്കുറവ്)';
        }

        return [
            'index' => $tithiIndex,
            'paksha_en' => $pakshaEn,
            'paksha_ml' => $pakshaMl,
            'name_en' => "{$pakshaEn} — {$tithiNameEn}",
            'name_ml' => "{$pakshaMl} — {$tithiNameMl}",
            'short_en' => $tithiNameEn,
            'short_ml' => $tithiNameMl,
            'moon_pakshabala' => $pakshabala,
        ];
    }

    /**
     * Karana calculation across 60 half-tithis (Vedanga Jyothisham Pages 20–21)
     */
    public function getKaranaDetails(int $karanaIndex): array
    {
        $charaKaranas = [
            0 => ['name_en' => 'Bava (Lion)', 'name_ml' => 'സിംഹം (ബവ)', 'type' => 'Charakarana'],
            1 => ['name_en' => 'Balava (Tiger)', 'name_ml' => 'പുലി (ബാലവ)', 'type' => 'Charakarana'],
            2 => ['name_en' => 'Kaulava (Pig)', 'name_ml' => 'പന്നി (കൗലവ)', 'type' => 'Charakarana'],
            3 => ['name_en' => 'Taitila (Donkey)', 'name_ml' => 'കഴുത (തൈതില)', 'type' => 'Charakarana'],
            4 => ['name_en' => 'Gara (Elephant)', 'name_ml' => 'ആന (ഗരജ)', 'type' => 'Charakarana'],
            5 => ['name_en' => 'Vanija (Cow)', 'name_ml' => 'പശു (വണിജ)', 'type' => 'Charakarana'],
            6 => ['name_en' => 'Vishti (Bhadra)', 'name_ml' => 'വിഷ്ടി (ഭദ്ര)', 'type' => 'Charakarana (Inauspicious)'],
        ];

        if ($karanaIndex === 1) {
            return ['index' => 1, 'name_en' => 'Kimstughna (Worms)', 'name_ml' => 'പുഴു (കിംസ്തുഘ്നൻ)', 'type' => 'Sthirakarana'];
        }
        if ($karanaIndex === 58) {
            return ['index' => 58, 'name_en' => 'Shakuni (Bird/Falcon)', 'name_ml' => 'പുള്ള് (ശകുനി)', 'type' => 'Sthirakarana'];
        }
        if ($karanaIndex === 59) {
            return ['index' => 59, 'name_en' => 'Chatushpada (Quadruped)', 'name_ml' => 'നാൽക്കാലി (ചതുഷ്പാദം)', 'type' => 'Sthirakarana'];
        }
        if ($karanaIndex === 60) {
            return ['index' => 60, 'name_en' => 'Naga (Serpent)', 'name_ml' => 'പാമ്പ് (നാഗം)', 'type' => 'Sthirakarana'];
        }

        $cycleIdx = ($karanaIndex - 2) % 7;
        $k = $charaKaranas[$cycleIdx];
        $k['index'] = $karanaIndex;
        return $k;
    }

    public function reduceToSingleDigit(int $number): int
    {
        while ($number > 9) {
            $number = array_sum(array_map('intval', str_split((string) $number)));
        }
        return max(1, $number);
    }
}

