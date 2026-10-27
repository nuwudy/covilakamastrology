<?php

namespace App\Services;

use Carbon\Carbon;

class VedicDobCalculator
{
    protected static array $planets = [
        1 => [
            'en' => 'Surya (Sun)',
            'ml' => 'സൂര്യൻ (Surya)',
            'ta' => 'சூரியன் (Suriyan)',
            'hi' => 'सूर्य (Surya)',
            'archetype' => [
                'en' => 'The Sovereign Leader & Visionary (ഭരണാധികാരി)',
                'ml' => 'ഭരണാധികാരിയും ദീർഘദർശിയും (The Sovereign Leader & Visionary)',
                'ta' => 'ஆளுமைமிக்க தலைவர் மற்றும் தொலைநோக்காளர் (The Sovereign Leader)',
                'hi' => 'तेजस्वी नेता और दूरदर्शी (The Sovereign Leader & Visionary)',
            ],
            'deity' => [
                'en' => 'Lord Surya Narayana',
                'ml' => 'സൂര്യനാരായണ ഭഗവാൻ',
                'ta' => 'சூரிய நாராயண பகவான்',
                'hi' => 'भगवान सूर्य नारायण',
            ],
            'element' => [
                'en' => 'Fire / Radiance (അഗ്നിസ്വരൂപം)',
                'ml' => 'അഗ്നി / പ്രകാശം (തേജസ്സ്)',
                'ta' => 'நெருப்பு / பிரகாசம் (அக்னி)',
                'hi' => 'अग्नि / तेज (अग्नि तत्व)',
            ],
            'traits' => [
                'en' => 'Natural leadership, royal dignity, strong willpower, unshakeable integrity, and boundless vitality.',
                'ml' => 'സ്വാഭാവിക നേതൃപാടവം, രാജകീയ വ്യക്തിത്വം, ദൃഢനിശ്ചയം, സത്യസന്ധത, അചഞ്ചലമായ പ്രസരിപ്പ്.',
                'ta' => 'இயற்கையான தலைமைப்பண்பு, கம்பீரமான ஆளுமை, உறுதியான மனோபலம், உண்மைத்தன்மை, ஆற்றல்.',
                'hi' => 'स्वाभाविक नेतृत्व क्षमता, राजसी गरिमा, दृढ़ इच्छाशक्ति, सत्यनिष्ठा और असीम ऊर्जा।',
            ],
            'gemstone_en' => 'Ruby (Manikya)',
            'gemstone_ml' => 'മാണിക്യം (Natural Ruby)',
            'gemstone_ta' => 'மாணிக்கம் (Ruby)',
            'gemstone_hi' => 'माणिक्य (Ruby)',
            'wearing_rule' => [
                'en' => 'Wear in Gold or Copper on the Ring Finger on a bright Sunday morning after sunrise.',
                'ml' => 'ഞായറാഴ്ച രാവിലെ സൂര്യോദയത്തിന് ശേഷം സ്വർണ്ണത്തിലോ ചെമ്പിലോ മോതിരവിരലിൽ ധരിക്കുക.',
                'ta' => 'ஞாயிற்றுக்கிழமை காலையில் சூரிய உதயத்திற்குப் பின் தங்கம் அல்லது செம்பில் மோதிர விரலில் அணியவும்.',
                'hi' => 'रविवार की सुबह सूर्योदय के बाद सोने या तांबे में अनामिका अंगुली में धारण करें।',
            ],
            'lucky_color' => [
                'en' => 'Ruby Red, Royal Gold, Saffron, Bright Orange',
                'ml' => 'ചുവപ്പ്, സ്വർണ്ണവർണ്ണം, കുങ്കുമവർണ്ണം, ഓറഞ്ച്',
                'ta' => 'சிவப்பு, தங்க நிறம், குங்குமப்பூ நிறம், ஆரஞ்சு',
                'hi' => 'माणिक लाल, सुनहरा, केसरिया, गहरा नारंगी',
            ],
            'lucky_day' => [
                'en' => 'Sunday (ഞായറാഴ്ച)',
                'ml' => 'ഞായറാഴ്ച (Sunday)',
                'ta' => 'ஞாயிற்றுக்கிழமை (Sunday)',
                'hi' => 'रविवार (Sunday)',
            ],
            'lucky_numbers' => '1, 10, 19, 28 (supportive: 2, 3, 9)',
            'favorable_direction' => [
                'en' => 'East (കിഴക്ക് - Direction of Surya Deva)',
                'ml' => 'കിഴക്ക് (East - സൂര്യദേവന്റെ ദിശ)',
                'ta' => 'கிழக்கு (East - சூரிய பகவானின் திசை)',
                'hi' => 'पूर्व (East - सूर्य देव की दिशा)',
            ],
            'mantra_sanskrit' => 'ॐ ह्रां ह्रीं ह्रौं सः सूर्याय नमः ॥',
            'mantra_translit' => 'Om Hraam Hreem Hroum Sah Sooryaya Namah',
            'personality_prediction' => [
                'en' => 'Governed by Lord Surya, the cosmic king and soul-significator (Atmakaraka), you possess a commanding aura, high self-esteem, and an innate capacity to inspire others. You are naturally drawn to independence and abhor subordination. Your thoughts are luminous, direct, and ambitious. When balanced, you serve as a protective fatherly or mentor figure to those around you, upholding truth and dharma with royal grace.',
                'ml' => 'ഗ്രഹങ്ങളുടെ അധിപനായ സൂര്യഭഗവാന്റെ സ്വാധീനമുള്ള താങ്കൾ ആജ്ഞാശക്തിയും ആത്മവിശ്വാസവും ഉള്ള വ്യക്തിയാണ്. സ്വാതന്ത്ര്യത്തെയും ആത്മാഭിമാനത്തെയും അങ്ങേയറ്റം വിലമതിക്കുന്ന താങ്കൾക്ക് അന്യരുടെ കീഴിൽ പ്രവർത്തിക്കുന്നതിനേക്കാൾ സ്വതന്ത്രമായി കാര്യങ്ങൾ നയിക്കാനാണ് താല്പര്യം. ഏത് പ്രതിസന്ധിയിലും സത്യത്തിന്റെയും ധർമ്മത്തിന്റെയും പക്ഷത്ത് ഉറച്ചുനിൽക്കാൻ താങ്കൾക്ക് സാധിക്കും.',
                'ta' => 'சூரிய பகவானின் ஆதிக்கம் பெற்ற நீங்கள் கம்பீரமான ஆளுமையும், தலைமைப்பண்பும், உயர்ந்த சுயமரியாதையும் கொண்டவர். பிறருக்குக் கீழ் வேலை செய்வதை விட, சுயசார்புடன் முன்னோடியாக செயல்படுவதையே விரும்புவீர்கள். நேர்மையும் தர்மமும் உங்களின் மிகப்பெரிய பலம். உங்களைச் சுற்றியுள்ளவர்களுக்கு நீங்கள் என்றும் வழிகாட்டியாகவும் பாதுகாவலராகவும் திகழ்வீர்கள்.',
                'hi' => 'सूर्य देव के प्रभाव से आपमें जन्मजात नेतृत्व क्षमता, आत्म-सम्मान और तेजस्विता है। आप स्वतंत्रता प्रिय हैं और किसी के अधीन रहकर काम करने के बजाय स्वयं मार्गदर्शक बनना पसंद करते हैं। आपके विचार स्पष्ट और महत्वाकांक्षी हैं। आप अपने सिद्धांतों और सत्यनिष्ठा से कभी समझौता नहीं करते हैं।',
            ],
            'career_prediction' => [
                'en' => 'You flourish in administrative leadership, governance, enterprise management, high-level civil services, entrepreneurship, judiciary, and medical leadership. You perform exceptionally when leading a vision rather than executing subordinate routines. Peak wealth growth occurs during your Sun-influenced cycles (ages 19, 28, 37, 46, and 55), where bold initiatives yield prosperous returns.',
                'ml' => 'ഭരണപരമായ ഉന്നതപദവികൾ, സിവിൽ സർവീസ്, വ്യാപാര സംരംഭങ്ങൾ, രാഷ്ട്രീയം, മെഡിക്കൽ രംഗം, ജുഡീഷ്യറി എന്നീ മേഖലകളിൽ താങ്കൾ വലിയ വിജയം കൈവരിക്കും. നിർദ്ദേശങ്ങൾ സ്വീകരിക്കുന്നതിനേക്കാൾ ആസൂത്രണം ചെയ്ത് നയിക്കുന്ന സ്ഥാനങ്ങളിലാണ് താങ്കളുടെ കഴിവുകൾ പൂർണ്ണമായി പ്രകാശിക്കുന്നത്. 19, 28, 37, 46, 55 എന്നീ പ്രായങ്ങളിൽ സാമ്പത്തിക വളർച്ചയും സൗഭാഗ്യങ്ങളും ഉന്നതിയിലെത്തും.',
                'ta' => 'நிர்வாகப் பணிகள், அரசுத்துறை, தொழில்துறை தலைமை, மருத்துவம், சட்டம் மற்றும் சொந்தத் தொழில் ஆகியவற்றில் நீங்கள் பெரும் வெற்றி பெறுவீர்கள். ஒரு அமைப்பை வழிநடத்தும் போது உங்கள் தனித்திறன் முழுமையாக வெளிப்படும். 19, 28, 37, 46, 55 ஆகிய வயதுகளில் உங்கள் தொழில் மற்றும் நிதி நிலையில் சிறப்பான உயர்வு ஏற்படும்.',
                'hi' => 'प्रशासनिक सेवाएं, उच्च पद, व्यापार, राजनीति, चिकित्सा क्षेत्र और स्वतंत्र नेतृत्व में आप अद्वितीय सफलता प्राप्त करते हैं। जब आप आगे रहकर नेतृत्व करते हैं, तब आपकी कार्यकुशलता सबसे अधिक चमकती है। 19, 28, 37, 46 और 55 वर्ष की आयु आपके लिए धन और प्रतिष्ठा के स्वर्णिम काल सिद्ध होंगे।',
            ],
            'relationship_prediction' => [
                'en' => 'In relationships, you are intensely loyal, generous, and protective. However, excessive pride or unintentional authoritativeness can occasionally create distance. Nurturing mutual respect and allowing your partner equal space ensures lifelong marital bliss and domestic peace.',
                'ml' => 'ബന്ധങ്ങളിൽ അങ്ങേയറ്റം വിശ്വസ്തതയും സ്നേഹവും കാത്തുസൂക്ഷിക്കുന്ന വ്യക്തിയാണ് താങ്കൾ. എങ്കിലും കുടുംബജീവിതത്തിൽ സ്വാഭാവികമായി കടന്നുവരുന്ന ശാഠ്യമോ ആജ്ഞാഭാവമോ പങ്കാളിയുമായി ചെറിയ അകൽച്ചയുണ്ടാക്കാതെ ശ്രദ്ധിക്കുക. പങ്കാളിക്ക് തുല്യ പ്രാധാന്യം നൽകുന്നത് ദാമ്പത്യസൗഖ്യം വർദ്ധിപ്പിക്കും.',
                'ta' => 'குடும்பத்திலும் உறவுகளிலும் மிகுந்த அர்ப்பணிப்பும் விசுவாசமும் கொண்டவர். உங்கள் உள்ளத்தில் அன்பு நிறைந்திருந்தாலும், பேச்சில் வரும் மேலாதிக்கத் தோரணை சில நேரங்களில் புரிதலின்மையை ஏற்படுத்தலாம். வாழ்க்கைத் துணையின் கருத்துக்களுக்கு மதிப்பளிப்பது குடும்பத்தில் நீடித்த மகிழ்ச்சியைத் தரும்.',
                'hi' => 'रिश्तों में आप अत्यंत वफादार, उदार और संरक्षक स्वभाव के हैं। अपने स्वाभिमान को अहंकार में बदलने न दें और जीवनसाथी की भावनाओं का पूरा सम्मान करें। आपसी संवाद और सम्मान से आपका वैवाहिक जीवन सुखमय और सामंजस्यपूर्ण रहेगा।',
            ],
            'health_prediction' => [
                'en' => 'Surya governs vitality, the heart, eyesight, spine, and immune constitution (Ojas). Maintain adequate hydration, practice morning Surya Namaskar, soak in early morning sunlight, and avoid excessive fiery/pungent foods to sustain peak energy.',
                'ml' => 'സൂര്യൻ ഹൃദയം, കണ്ണ്, അസ്ഥികൾ, രോഗപ്രതിരോധ ശേഷി എന്നിവയെ നിയന്ത്രിക്കുന്നു. പ്രഭാത സൂര്യനമസ്കാരം, ധാരാളം വെള്ളം കുടിക്കുന്നത്, അമിത എരിവും ചൂടുമുള്ള ഭക്ഷണങ്ങൾ ഒഴിവാക്കുന്നത് എന്നിവ ആരോഗ്യവും ഉന്മേഷവും നിലനിർത്തും.',
                'ta' => 'சூரியன் இதயம், கண் பார்வை, எலும்புகள் மற்றும் உடலின் நோய் எதிர்ப்பு சக்தியை ஆள்கிறது. அதிகாலை சூரிய நமஸ்காரம், போதிய அளவு நீர் அருந்துதல், காரமான உணவுகளைக் குறைத்தல் ஆகியவை உங்கள் தேக ஆரோக்கியத்தை என்றும் காக்கும்.',
                'hi' => 'सूर्य देव हृदय, नेत्र ज्योति, रीढ़ की हड्डी और रोग प्रतिरोधक क्षमता का प्रतिनिधित्व करते हैं। प्रातःकाल सूर्य नमस्कार, पर्याप्त जल का सेवन और संतुलित आहार आपको सदैव स्वस्थ और ऊर्जावान रखेगा।',
            ],
            'doctor_remedy' => [
                'en' => 'Recite Aditya Hridaya Stotram on Sundays or chant the Surya Gayatri. Offer water mixed with red sandalwood and jaggery to the rising sun in a copper vessel for lasting fame and health.',
                'ml' => 'ഞായറാഴ്ചകളിൽ ആദിത്യഹൃദയ സ്തോത്രം ജപിക്കുകയോ സൂര്യഗായത്രി ചൊല്ലുകയോ ചെയ്യുക. രാവിലെ ചെമ്പ് പാത്രത്തിൽ ശുദ്ധജലത്തിൽ രക്തചന്ദനവും ശർക്കരയും ചേർത്ത് ഉദയസൂര്യന് അർഘ്യം സമർപ്പിക്കുന്നത് ശ്രേഷ്ഠമാണ്.',
                'ta' => 'ஞாயிற்றுக்கிழமைகளில் ஆதித்ய ஹிருதய ஸ்தோத்திரம் அல்லது காயத்ரி மந்திரம் பாராயணம் செய்யவும். செம்புப் பாத்திரத்தில் நீர், செஞ்சந்தனம் சேர்த்து உதய சூரியனுக்கு அர்க்கியம் அளிப்பது கீர்த்தியையும் உடல்நலத்தையும் தரும்.',
                'hi' => 'रविवार को आदित्य हृदय स्तोत्र का पाठ करें। तांबे के पात्र में जल, रोली और गुड़ मिलाकर उगते हुए सूर्य को अर्घ्य दें। इससे मान-सम्मान और आरोग्य की प्राप्ति होती है।',
            ],
        ],
        2 => [
            'en' => 'Chandra (Moon)',
            'ml' => 'ചന്ദ്രൻ (Chandra)',
            'ta' => 'சந்திரன் (Chandran)',
            'hi' => 'चंद्र (Chandra)',
            'archetype' => [
                'en' => 'The Intuitive Healer & Empath (കരുണാമയൻ)',
                'ml' => 'കരുണാമയനായ സാന്ത്വനകനും ദാർശനികനും (The Intuitive Healer)',
                'ta' => 'உள்ளுணர்வுமிக்க அன்பான வழிகாட்டி (The Intuitive Healer)',
                'hi' => 'सहृदय उपचारक और संवेदनशील पथप्रदर्शक (The Intuitive Healer)',
            ],
            'deity' => [
                'en' => 'Goddess Parvati / Chandra Bhagavan',
                'ml' => 'ശ്രീ പാർവ്വതീദേവി / ചന്ദ്രഭഗവാൻ',
                'ta' => 'ஸ்ரீ பார்வதி தேவி / சந்திர பகவான்',
                'hi' => 'माता पार्वती / चंद्र देव',
            ],
            'element' => [
                'en' => 'Water / Essence (ജലതത്ത്വം)',
                'ml' => 'ജലം / മനസ്സ് (ജലതത്ത്വം)',
                'ta' => 'நீர் / மனம் (ஜல தத்துவம்)',
                'hi' => 'जल / मन (जल तत्व)',
            ],
            'traits' => [
                'en' => 'Profound intuition, emotional empathy, artistic imagination, diplomatic peace-making, and gentle charisma.',
                'ml' => 'ആഴമേറിയ അന്തർജ്ഞാനം, കരുണ, കലാപരമായ ഭാവന, സമാധാനപ്രിയത, സൗമ്യമായ പെരുമാറ്റം.',
                'ta' => 'ஆழ்ந்த உள்ளுணர்வு, கருணை, கலைத்திறன், அமைதியை விரும்பும் குணம், கனிவான நடத்தை.',
                'hi' => 'गहन अंतर्ज्ञान, भावनात्मक संवेदनशीलता, कलात्मक कल्पना, शांतिप्रियता और सौम्य आकर्षण।',
            ],
            'gemstone_en' => 'Pearl (Muthu) / Moonstone',
            'gemstone_ml' => 'മുത്ത് (Natural Basra / South Sea Pearl)',
            'gemstone_ta' => 'முத்து (Natural Pearl)',
            'gemstone_hi' => 'मोती (Natural Pearl)',
            'wearing_rule' => [
                'en' => 'Wear in Pure Silver on the Little Finger on a Monday evening during Shukla Paksha.',
                'ml' => 'വെളുത്തപക്ഷ തിങ്കളാഴ്ച സന്ധ്യയ്ക്ക് ശുദ്ധമായ വെള്ളിയിൽ ചെറുവിരലിൽ ധരിക്കുക.',
                'ta' => 'வளர்பிறை திங்கட்கிழமை மாலை வேளையில் தூய வெள்ளியில் சுண்டு விரலில் அணியவும்.',
                'hi' => 'शुक्ल पक्ष के सोमवार की शाम को शुद्ध चांदी में कनिष्ठिका (छोटी) अंगुली में धारण करें।',
            ],
            'lucky_color' => [
                'en' => 'Pearl White, Silver, Sea Green, Cream',
                'ml' => 'വെളുപ്പ്, വെള്ളി, ഇളം പച്ച, ക്രീം',
                'ta' => 'வெள்ளை, வெள்ளி நிறம், கடல் பச்சை, கிரீம்',
                'hi' => 'दूधिया सफेद, चांदी जैसा, हल्का हरा, क्रीम',
            ],
            'lucky_day' => [
                'en' => 'Monday (തിങ്കളാഴ്ച)',
                'ml' => 'തിങ്കളാഴ്ച (Monday)',
                'ta' => 'திங்கட்கிழமை (Monday)',
                'hi' => 'सोमवार (Monday)',
            ],
            'lucky_numbers' => '2, 11, 20, 29 (supportive: 1, 7)',
            'favorable_direction' => [
                'en' => 'Northwest (വായുകോൺ - Vayu Konam)',
                'ml' => 'വടക്ക്-പടിഞ്ഞാറ് (വായുകോൺ)',
                'ta' => 'வடமேற்கு (வாயு மூலை)',
                'hi' => 'वायव्य कोण (उत्तर-पश्चिम दिशा)',
            ],
            'mantra_sanskrit' => 'ॐ श्रां श्रीं श्रौं सः चन्द्राय नमः ॥',
            'mantra_translit' => 'Om Shraam Shreem Shroum Sah Chandraaya Namah',
            'personality_prediction' => [
                'en' => 'As a native of Chandra Deva (significator of the Mind - Manas), your consciousness is receptive, perceptive, and deeply compassionate. You possess psychic-grade intuition that senses subtle shifts in people and surroundings before words are spoken. You have a deep love for aesthetics, nature, music, and peace.',
                'ml' => 'മനസ്സിന്റെ കാരകനായ ചന്ദ്രന്റെ അനുഗ്രഹമുള്ള താങ്കൾ അതീവ സഹൃദയനും ഭാവനാശാലിയുമാണ്. വാക്കുകൾക്ക് അതീതമായി മറ്റുള്ളവരുടെ വികാരങ്ങളെ ഉൾക്കൊള്ളാൻ താങ്കൾക്ക് സവിശേഷമായ കഴിവുണ്ട്. കലകൾ, സംഗീതം, പ്രകൃതിഭംഗി എന്നിവയിൽ താങ്കൾ ആനന്ദം കണ്ടെത്തുന്നു. മനസ്സിന്റെ ചാഞ്ചല്യം നിയന്ത്രിച്ചാൽ ഏത് രംഗത്തും തിളങ്ങാം.',
                'ta' => 'மனோகாரகனான சந்திரனின் ஆதிக்கம் பெற்ற நீங்கள் மென்மையான உள்ளமும், இரக்க குணமும், சிறந்த கற்பனைத் திறனும் கொண்டவர். பிறர் சொல்லாமலேயே அவர்களின் உணர்வுகளைப் புரிந்து கொள்ளும் உள்ளுணர்வு உங்களுக்கு உண்டு. கலை, இசை மற்றும் இயற்கையை பெரிதும் நேசிப்பீர்கள்.',
                'hi' => 'मन के कारक चंद्र देव के प्रभाव से आप अत्यंत संवेदनशील, दयालु और कल्पनाशील हैं। आपके पास दूसरों की भावनाओं को बिना कहे समझ लेने की अद्भुत क्षमता है। आप कला, संगीत और प्राकृतिक सौंदर्य के प्रेमी हैं। मन की एकाग्रता से आप महान सफलता पाते हैं।',
            ],
            'career_prediction' => [
                'en' => 'Ideal career vocations include counseling, psychology, fine arts, public diplomacy, maritime/liquid industries, human resources, pharmaceuticals, teaching, and hospitality. Your collaborative nature makes you beloved by teams and clients.',
                'ml' => 'മനഃശാസ്ത്രം, കൗൺസിലിംഗ്, അദ്ധ്യാപനം, കലകൾ, മാധ്യമരംഗം, ഹോസ്പിറ്റാലിറ്റി, ഫാർമസ്യൂട്ടിക്കൽ, ജലസംബന്ധമായ മേഖലകൾ എന്നിവയിൽ താങ്കൾ തിളങ്ങും. എല്ലാവരുമായും ഇണങ്ങി പ്രവർത്തിക്കാനുള്ള താങ്കളുടെ സൗമ്യശൈലി സഹപ്രവർത്തകരുടെയും ഉന്നതാധികാരികളുടെയും പ്രീതി നേടും.',
                'ta' => 'மனநல ஆலோசனை, கற்பித்தல், நுண்கலைகள், மக்கள் தொடர்பு, மருத்துவம், விருந்தோம்பல் மற்றும் உணவு/பானத் துறைகளில் அபார வெற்றி கிடைக்கும். அனைவரையும் அரவணைத்துச் செல்லும் உங்கள் குணம் உங்களை அனைவரிடமும் அன்பிற்குரியவராக்கும்.',
                'hi' => 'काउंसलिंग, मनोविज्ञान, शिक्षण, ललित कला, जनसंपर्क, औषधि उद्योग, आतिथ्य सत्कार और रचनात्मक क्षेत्रों में आपका करियर अत्यंत उज्ज्वल रहेगा। आपका मिलनसार स्वभाव आपको हर जगह लोकप्रिय बनाता है।',
            ],
            'relationship_prediction' => [
                'en' => 'You crave emotional security, devotion, and tenderness in love. When loved authentically, you become an unwavering anchor of warmth and maternal/paternal care. Guard against emotional over-sensitivity and moods influenced by the lunar phases.',
                'ml' => 'സ്നേഹത്തിലും ദാമ്പത്യത്തിലും ആത്മാർത്ഥതയും പരസ്പര വിശ്വാസവുമാണ് താങ്കൾ ഏറ്റവും കൂടുതൽ കൊതിക്കുന്നത്. അർഹമായ പരിഗണന ലഭിക്കുമ്പോൾ താങ്കൾ കുടുംബത്തിന്റെ തണലായി മാറും. എങ്കിലും അനാവശ്യ ഉത്കണ്ഠകളും മുൻകോപവും നിയന്ത്രിക്കുന്നത് കുടുംബസമാധാനത്തിന് അത്യന്താപേക്ഷിതമാണ്.',
                'ta' => 'அன்பிலும் குடும்பத்திலும் உண்மையான பாசத்தையும், பாதுகாப்பு உணர்வையும் எதிர்பார்ப்பீர்கள். தகுந்த அன்பு கிடைத்தால் குடும்பத்தின் அன்பான தூணாகத் திகழ்வீர்கள். அதிகப்படியான உணர்ச்சிவசப்படுதலைத் தவிர்ப்பது மன அமைதியைத் தரும்.',
                'hi' => 'प्रेम और वैवाहिक जीवन में आप अटूट समर्पण और भावनात्मक सुरक्षा चाहते हैं। सच्चा स्नेह मिलने पर आप परिवार के लिए पूर्ण समर्पित रहते हैं। अत्यधिक भावुकता और चिंता से बचना आपके लिए हितकर रहेगा।',
            ],
            'health_prediction' => [
                'en' => 'Chandra governs bodily fluids, lymphatic circulation, emotional equilibrium, and sleep cycles. Protect your respiratory system from dampness and cold. Meditation near clean water bodies and consuming warm milk infused with cardamom before sleep promotes restorative rest.',
                'ml' => 'ചന്ദ്രൻ കഫദോഷത്തെയും ഉറക്കത്തെയും നിയന്ത്രിക്കുന്നു. ജലദോഷം, ശ്വാസകോശ അലർജികൾ എന്നിവ വരാൻ സാധ്യതയുള്ളതിനാൽ തണുപ്പുള്ള അന്തരീക്ഷത്തിൽ ശ്രദ്ധിക്കുക. രാത്രി ഏലക്കായ ചേർത്ത ഇളം ചൂടുള്ള പാൽ കുടിക്കുന്നത് സുഖനിദ്രയ്ക്കും മനശ്ശാന്തിക്കും ഉത്തമമാണ്.',
                'ta' => 'சந்திரன் உடல் திரவங்கள், தூக்கம் மற்றும் மன அமைதியைக் குறிக்கிறது. சளி, சுவாசக் கோளாறுகளில் இருந்து தற்காத்துக் கொள்ளுங்கள். தியானம் மற்றும் இரவில் வெதுவெதுப்பான பால் அருந்துதல் நலம் தரும்.',
                'hi' => 'चंद्र देव शरीर में जल तत्व, नींद और मानसिक शांति के नियंत्रक हैं। कफ और मौसमी जुकाम से सावधान रहें। ध्यान लगाना और रात्रि में इलायची युक्त गुनगुना दूध लेना आपके स्वास्थ्य के लिए उत्तम है।',
            ],
            'doctor_remedy' => [
                'en' => 'Observe silence or fast on Monday evenings, worship Lord Shiva and Goddess Parvati, and offer milk or white flowers at a temple on Purnima (Full Moon) days for boundless mental clarity.',
                'ml' => 'തിങ്കളാഴ്ചകളിൽ ശിവക്ഷേത്ര ദർശനം നടത്തുക, പൗർണ്ണമി നാളുകളിൽ വെളുത്ത പുഷ്പങ്ങളോ പാലോ ശിവന് അർപ്പിക്കുക. ഇത് മനസ്സിന് ശാന്തിയും ഐശ്വര്യവും പ്രദാനം ചെയ്യും.',
                'ta' => 'திங்கட்கிழமைகளில் சிவபெருமானையும் அம்பாளையும் வழிபடவும். பௌர்ணமி நாட்களில் பால் அல்லது வெள்ளை மலர்கள் சமர்ப்பித்து வழிபட மனத் தெளிவும் நிம்மதியும் கிட்டும்.',
                'hi' => 'सोमवार को भगवान शिव और माता पार्वती की आराधना करें। पूर्णिमा के दिन कच्चा दूध या सफेद फूल शिवलिंग पर अर्पित करने से मानसिक शांति और सुख-समृद्धि बढ़ती है।',
            ],
        ],
        3 => [
            'en' => 'Guru / Brihaspati (Jupiter)',
            'ml' => 'ഗുരു / വ്യാഴം (Brihaspati)',
            'ta' => 'குரு / பிரகஸ்பதி (Guru)',
            'hi' => 'बृहस्पति / गुरु (Jupiter)',
            'archetype' => [
                'en' => 'The Wise Preceptor & Dharma Guardian (ഗുരുനാഥൻ)',
                'ml' => 'ഗുരുനാഥനും ധർമ്മസംരക്ഷകനും (The Wise Preceptor)',
                'ta' => 'ஞான குரு மற்றும் தர்ம காவலர் (The Wise Preceptor)',
                'hi' => 'ज्ञानवान गुरु और धर्म रक्षक (The Wise Preceptor)',
            ],
            'deity' => [
                'en' => 'Lord Dakshinamurthy / Maharshi Brihaspati',
                'ml' => 'ശ്രീ ദക്ഷിണാമൂർത്തി / ബൃഹസ്പതി',
                'ta' => 'ஸ்ரீ தட்சிணாமூர்த்தி / பிரகஸ்பதி',
                'hi' => 'भगवान दक्षिणामूर्ति / देवगुरु बृहस्पति',
            ],
            'element' => [
                'en' => 'Ether / Cosmic Space (ആകാശതത്ത്വം)',
                'ml' => 'ആകാശം / ജ്ഞാനം (ആകാശതത്ത്വം)',
                'ta' => 'ஆகாயம் / ஞானம் (ஆகாய தத்துவம்)',
                'hi' => 'आकाश / विवेक (आकाश तत्व)',
            ],
            'traits' => [
                'en' => 'High philosophical intellect, righteousness, benevolent mentorship, optimism, and spiritual mastery.',
                'ml' => 'ദാർശനിക ജ്ഞാനം, നീതിബോധം, അധ്യാപന പാടവം, ശുഭാപ്തിവിശ്വാസം, ആത്മീയ ഔന്നത്യം.',
                'ta' => 'உயர்ந்த ஞானம், நீதி நேர்மை, சிறந்த வழிகாட்டுதல், நன்னம்பிக்கை, ஆன்மீக ஈடுபாடு.',
                'hi' => 'उच्च दार्शनिक बुद्धि, धर्मपरायणता, कुशल मार्गदर्शन, सकारात्मकता और आध्यात्मिक झुकाव।',
            ],
            'gemstone_en' => 'Yellow Sapphire (Pushparagam)',
            'gemstone_ml' => 'പുഷ്യരാഗം (Yellow Sapphire / Topaz)',
            'gemstone_ta' => 'புஷ்பராகம் (Yellow Sapphire)',
            'gemstone_hi' => 'पुखराज (Yellow Sapphire)',
            'wearing_rule' => [
                'en' => 'Wear in Gold on the Index (Tarjani) Finger on a Thursday morning after bathing.',
                'ml' => 'വ്യാഴാഴ്ച രാവിലെ സ്നാനത്തിന് ശേഷം ശുദ്ധമായ സ്വർണ്ണത്തിൽ ചൂണ്ടുവിരലിൽ ധരിക്കുക.',
                'ta' => 'வியாழக்கிழமை காலையில் தூய தங்கத்தில் ஆள்காட்டி விரலில் அணியவும்.',
                'hi' => 'गुरुवार की सुबह स्नान के पश्चात सोने में तर्जनी (पहली) अंगुली में धारण करें।',
            ],
            'lucky_color' => [
                'en' => 'Golden Yellow, Bright Saffron, Turmeric Gold',
                'ml' => 'മഞ്ഞ, കടും മഞ്ഞ, മഞ്ഞൾ നിറം, സുവർണ്ണ വർണ്ണം',
                'ta' => 'தங்க மஞ்சள், பிரகாசமான குங்கும மஞ்சள், மஞ்சள்',
                'hi' => 'सुनहरा पीला, हल्दी जैसा पीला, केसरिया',
            ],
            'lucky_day' => [
                'en' => 'Thursday (വ്യാഴാഴ്ച)',
                'ml' => 'വ്യാഴാഴ്ച (Thursday)',
                'ta' => 'வியாழக்கிழமை (Thursday)',
                'hi' => 'गुरुवार (Thursday)',
            ],
            'lucky_numbers' => '3, 12, 21, 30 (supportive: 1, 9)',
            'favorable_direction' => [
                'en' => 'Northeast (ഈശാനകോൺ - Sacred Direction)',
                'ml' => 'വടക്ക്-കിഴക്ക് (ഈശാനകോൺ - അതീവ പവിത്രം)',
                'ta' => 'வடகிழக்கு (ஈசானிய மூலை - மங்கலகரமான திசை)',
                'hi' => 'ईशान कोण (उत्तर-पूर्व दिशा - अत्यंत शुभ)',
            ],
            'mantra_sanskrit' => 'ॐ ग्रां ग्रीं ग्रौं सः गुरवे नमः ॥',
            'mantra_translit' => 'Om Graam Greem Groum Sah Gurave Namah',
            'personality_prediction' => [
                'en' => 'Blessed by Brihaspati, the preceptor of the Gods, you are endowed with natural wisdom, ethical fortitude, and broad-minded nobility. You seek the underlying meaning of life, despise pettiness, and have a natural instinct to guide and educate others. People instinctively turn to you for counsel during crises.',
                'ml' => 'ദേവഗുരുവായ ബൃഹസ്പതിയുടെ അനുഗ്രഹമുള്ള താങ്കൾ വിശാലമനസ്സും അറിവും കാര്യപ്രാപ്തിയുമുള്ള വ്യക്തിയാണ്. ആഴമേറിയ ചിന്താശേഷിയും മറ്റുള്ളവരെ നയിക്കാനും ഉപദേശിക്കാനുമുള്ള ജന്മസിദ്ധമായ കഴിവും താങ്കൾക്കുണ്ട്. സങ്കീർണ്ണമായ പ്രശ്നങ്ങളിൽ ആളുകൾ താങ്കളുടെ മാർഗ്ഗനിർദ്ദേശം തേടിയെത്തും.',
                'ta' => 'தேவகுருவின் அருள் பெற்ற நீங்கள் ஆழ்ந்த ஞானமும், பெருந்தன்மையும், நீதியான சிந்தனையும் கொண்டவர். சிறுமைகளை வெறுத்து, எப்போதும் தர்ம வழியில் நடப்பீர்கள். நெருக்கடி நேரங்களில் பலரும் உங்களிடம் ஆலோசனை கேட்டு வருவார்கள்.',
                'hi' => 'देवगुरु बृहस्पति की कृपा से आपमें स्वाभाविक विवेक, नैतिकता और विशाल दृष्टिकोण है। आप जीवन के गहरे अर्थ को समझते हैं और दूसरों को उचित राह दिखाने की क्षमता रखते हैं। संकट के समय लोग आपसे सलाह लेने आते हैं।',
            ],
            'career_prediction' => [
                'en' => 'You excel in higher education, law, judiciary, financial advisory, corporate consultancy, spiritual leadership, publishing, and international diplomacy. Financial abundance comes naturally when you remain true to ethical conduct and continuous learning.',
                'ml' => 'ഉന്നത വിദ്യാഭ്യാസം, നിയമം, ധനകാര്യ ഉപദേശം, ബാങ്കിംഗ്, കൺസൾട്ടൻസി, ആത്മീയ പ്രഭാഷണം, എഴുത്ത് എന്നീ മേഖലകളിൽ താങ്കൾ പ്രശസ്തിയും നേട്ടങ്ങളും കൈവരിക്കും. ധാർമ്മികമായ മാർഗ്ഗത്തിലൂടെയുള്ള സമ്പാദ്യം താങ്കൾക്ക് നിലനിൽക്കുന്ന ഐശ്വര്യം നൽകും.',
                'ta' => 'உயர் கல்வி, சட்டம், நீதித்துறை, நிதி ஆலோசனை, வங்கிப்பணி, ஆன்மீகச் சொற்பொழிவு, புத்தக வெளியீடு ஆகியவற்றில் பெரும் புகழ் அடைவீர்கள். நேர்மையான உழைப்பால் செல்வமும் மரியாதையும் உங்களைத் தேடி வரும்.',
                'hi' => 'उच्च शिक्षा, कानून, न्यायपालिका, वित्तीय परामर्श, बैंकिंग, कॉर्पोरेट कंसल्टेंसी और आध्यात्मिक नेतृत्व में आप सफलता के शिखर पर पहुंचते हैं। आपकी सत्यनिष्ठा ही आपके धन और मान का मुख्य स्रोत बनेगी।',
            ],
            'relationship_prediction' => [
                'en' => 'You seek intellectual companionship and philosophical resonance in a partner. You are honest, generous, and steady in marriage. Avoid excessive preachiness and remember that emotional warmth is just as vital as intellectual truth.',
                'ml' => 'ദാമ്പത്യത്തിൽ സത്യസന്ധതയും പരസ്പര ബഹുമാനവും പുലർത്തുന്ന പങ്കാളിയെയാണ് താങ്കൾ ആഗ്രഹിക്കുന്നത്. ഗൃഹഭരണത്തിൽ കാര്യപ്രാപ്തി കാട്ടുമെങ്കിലും, കുടുംബാംഗങ്ങളെ എപ്പോഴും ഉപദേശിക്കുന്നത് ഒഴിവാക്കി സ്നേഹത്തോടെയുള്ള ഇടപെടലുകൾ വർദ്ധിപ്പിക്കുക.',
                'ta' => 'அறிவுப்பூர்வமான உரையாடலும், பரஸ்பர மரியாதையும் உள்ள துணையை நாடுவீர்கள். குடும்பத்தில் நிலையான அன்பைப் பொழிவீர்கள். எந்நேரமும் அறிவுரை கூறாமல், கனிவான பாசத்தைக் காட்டுவது தம்பதியரிடையே நெருக்கத்தை வளர்க்கும்.',
                'hi' => 'वैवाहिक जीवन में आप बौद्धिक तालमेल और आपसी आदर को सर्वोच्च मानते हैं। आप ईमानदार और उदार जीवनसाथी साबित होते हैं। बहुत अधिक उपदेश देने के बजाय भावनात्मक मधुरता बनाए रखना सुखद रहेगा।',
            ],
            'health_prediction' => [
                'en' => 'Jupiter governs the liver, circulation of arterial blood, hips, and metabolism. Avoid overindulgence in sugary, rich, or greasy delicacies. Regular brisk walking, liver-detox herbal teas, and turmeric milk sustain vitality.',
                'ml' => 'വ്യാഴം കരൾ, കൊഴുപ്പ്, ദഹനപ്രക്രിയ എന്നിവയെ നിയന്ത്രിക്കുന്നു. മധുരപലഹാരങ്ങളും അമിത കൊഴുപ്പുള്ള ഭക്ഷണങ്ങളും നിയന്ത്രിക്കുക. നിത്യേനയുള്ള നടത്തവും മഞ്ഞൾ ചേർത്ത പാനീയങ്ങളും ശരീരത്തിന് ഉന്മേഷമേകും.',
                'ta' => 'குரு பகவான் கல்லீரல், ரத்த ஓட்டம் மற்றும் செரிமானத்தை ஆள்கிறார். அதிக இனிப்பு மற்றும் கொழுப்புள்ள உணவுகளைத் தவிர்க்கவும். நடைபயிற்சியும் மஞ்சள் பாலும் ஆரோக்கியம் தரும்.',
                'hi' => 'बृहस्पति देव यकृत (लिवर), रक्त संचार और पाचन क्रिया का प्रतिनिधित्व करते हैं। अत्यधिक मीठे और वसायुक्त भोजन से बचें। नियमित रूप से टहलना और हल्दी का सेवन स्वास्थ्यवर्धक रहेगा।',
            ],
            'doctor_remedy' => [
                'en' => 'Apply a tilak of pure saffron or turmeric to your forehead and throat on Thursdays. Feed cows or sponsor education for deserving students to activate Jupiter’s supreme grace.',
                'ml' => 'വ്യാഴാഴ്ചകളിൽ നെറ്റിയിലും തൊണ്ടയിലും കസ്തൂരിമഞ്ഞളോ കുങ്കുമപ്പൂവോ ചന്ദനമോ തൊടുക. പശുക്കൾക്ക് തീറ്റ നൽകുന്നതും പാവപ്പെട്ട വിദ്യാർത്ഥികൾക്ക് പഠനസഹായം നൽകുന്നതും വ്യാഴപ്രീതിക്ക് ഉത്തമമാണ്.',
                'ta' => 'வியாழக்கிழமைகளில் நெற்றியில் மஞ்சள் அல்லது சந்தனத் திலகம் அணியவும். பசுவுக்கு உணவளிப்பதும், ஏழை மாணவர்களின் கல்விக்கு உதவுவதும் குருவின் அருள்மழையைப் பொழியும்.',
                'hi' => 'गुरुवार को माथे और कंठ पर केसर या हल्दी का तिलक लगाएं। गाय को हरा चारा खिलाएं या किसी निर्धन विद्यार्थी की शिक्षा में सहायता करें। इससे गुरु का परम अनुग्रह प्राप्त होता है।',
            ],
        ],
        4 => [
            'en' => 'Rahu (North Node of Moon)',
            'ml' => 'രാഹു (Rahu)',
            'ta' => 'ராகு (Rahu)',
            'hi' => 'राहु (Rahu)',
            'archetype' => [
                'en' => 'The Disruptive Visionary & Tech Architect (നൂതന ചിന്തകൻ)',
                'ml' => 'നൂതന ചിന്തകനും വിപ്ലവകാരിയും (The Disruptive Visionary)',
                'ta' => 'புரட்சிகர சிந்தனையாளர் மற்றும் தொழில்நுட்ப நிபுணர் (The Visionary)',
                'hi' => 'युगद्रष्टा और तकनीकी शिल्पी (The Disruptive Visionary)',
            ],
            'deity' => [
                'en' => 'Lord Sarpa Raja / Goddess Durga Devi',
                'ml' => 'നാഗരാജാവ് / ശ്രീ ദുർഗ്ഗാദേവി',
                'ta' => 'நாகராஜர் / ஸ்ரீ துர்கா தேவி',
                'hi' => 'नागराज / माँ दुर्गा',
            ],
            'element' => [
                'en' => 'Air / Cosmic Mystery (വായു / നിഗൂഢത)',
                'ml' => 'വായു / നിഗൂഢത (ആകാശസൂക്ഷ്മം)',
                'ta' => 'காற்று / மர்மம் (வாயு தத்துவம்)',
                'hi' => 'वायु / गूढ़ रहस्य (वायु तत्व)',
            ],
            'traits' => [
                'en' => 'Unconventional thinking, technological foresight, strategic depth, resilience against adversity, and visionary ambition.',
                'ml' => 'വ്യത്യസ്തമായ ചിന്താരീതി, സാങ്കേതികജ്ഞാനം, തന്ത്രപരമായ ബുദ്ധി, പ്രതിസന്ധികളെ അതിജീവിക്കാനുള്ള മനക്കരുത്ത്.',
                'ta' => 'புதுமையான சிந்தனை, நவீன தொழில்நுட்ப அறிவு, சவால்களை வெல்லும் மன உறுதி, தொலைநோக்குப் பார்வை.',
                'hi' => 'परंपरा से हटकर सोचने की क्षमता, तकनीकी दूरदर्शिता, रणनीतिक गहराई और बाधाओं से लड़ने का साहस।',
            ],
            'gemstone_en' => 'Hessonite / Gomed (Gomedhakam)',
            'gemstone_ml' => 'ഗോമേദകം (Pure Cinnamon Hessonite)',
            'gemstone_ta' => 'கோமேதகம் (Hessonite Garnet)',
            'gemstone_hi' => 'गोमेद (Hessonite Garnet)',
            'wearing_rule' => [
                'en' => 'Wear in Silver or Ashtadhatu on the Middle Finger on a Saturday evening during Rahu Kalam.',
                'ml' => 'ശനിയാഴ്ച വൈകുന്നേരം രാഹുകാലത്ത് വെള്ളിയിലോ അഷ്ടധാതുവിലോ നടുവിരലിൽ ധരിക്കുക.',
                'ta' => 'சனிக்கிழமை மாலை ராகு காலத்தில் வெள்ளி அல்லது அஷ்டதாதுவில் நடுவிரலில் அணியவும்.',
                'hi' => 'शनिवार की शाम को राहु काल में चांदी या अष्टधातु में मध्यमा (बीच की) अंगुली में धारण करें।',
            ],
            'lucky_color' => [
                'en' => 'Smoky Blue, Honey Brown, Steel Grey',
                'ml' => 'കടും നീല, തേൻ നിറം, ചാരനിറം',
                'ta' => 'சாம்பல் நிறம், தேன் நிறம், அடர் நீலம்',
                'hi' => 'धूम्र नीला, भूरा (शहद जैसा), गहरा स्लेटी',
            ],
            'lucky_day' => [
                'en' => 'Saturday (ശനിയാഴ്ച)',
                'ml' => 'ശനിയാഴ്ച (Saturday)',
                'ta' => 'சனிக்கிழமை (Saturday)',
                'hi' => 'शनिवार (Saturday)',
            ],
            'lucky_numbers' => '4, 13, 22, 31 (supportive: 1, 6)',
            'favorable_direction' => [
                'en' => 'Southwest (കന്നികോൺ - Nirrithi Konam)',
                'ml' => 'തെക്ക്-പടിഞ്ഞാറ് (കന്നികോൺ)',
                'ta' => 'தென்மேற்கு (கன்னி மூலை)',
                'hi' => 'नैऋत्य कोण (दक्षिण-पश्चिम दिशा)',
            ],
            'mantra_sanskrit' => 'ॐ भ्रां भ्रीं भ्रौं सः राहवे नमः ॥',
            'mantra_translit' => 'Om Bhraam Bhreem Bhroum Sah Raahave Namah',
            'personality_prediction' => [
                'en' => 'Influenced by Rahu, the cosmic catalyst of sudden breakthroughs, your mind operates outside conventional boundaries. You see patterns and opportunities that others miss. You are skeptical of dogma and possess an uncanny knack for modernization, technology, research, and large-scale strategy.',
                'ml' => 'രാഹുവിന്റെ സ്വാധീനം താങ്കൾക്ക് അസാധാരണമായ ഉൾക്കാഴ്ചയും വേറിട്ട ബുദ്ധിവൈഭവവും നൽകുന്നു. പരമ്പരാഗത ചട്ടക്കൂടുകൾക്കപ്പുറം ചിന്തിക്കാനും ആധുനിക സങ്കേതങ്ങളെ വേഗത്തിൽ സ്വായത്തമാക്കാനും താങ്കൾക്ക് കഴിയും. അപ്രതീക്ഷിതമായ പ്രതിസന്ധികളിലും പതറാതെ വഴി കണ്ടെത്താനുള്ള മനക്കരുത്തുണ്ട്.',
                'ta' => 'ராகு பகவானின் ஆற்றலால் நீங்கள் புதுமையான சிந்தனைகளும், பெரிய திட்டங்களைத் தீட்டும் சாமர்த்தியமும் கொண்டவர். வழக்கமான பாதையை விடுத்து, தனித்துவமான வழியில் சென்று சாதனை படைப்பீர்கள். நவீன தொழில்நுட்பம் மற்றும் மர்மங்களை எளிதில் கிரகித்துக் கொள்வீர்கள்.',
                'hi' => 'राहु के प्रभाव से आपका मस्तिष्क स्थापित सीमाओं से परे सोचता है। आप उन अवसरों को पहचान लेते हैं जिन्हें अन्य लोग देख नहीं पाते। आपमें आधुनिकता, तकनीकी दक्षता, शोध और बड़े पैमाने पर रणनीति बनाने की अद्भुत क्षमता है।',
            ],
            'career_prediction' => [
                'en' => 'High success in software engineering, artificial intelligence, aviation, foreign trade, electronic media, research, investigative journalism, and innovative startups. Bold calculations and risk-taking lead to monumental leaps in prosperity.',
                'ml' => 'സോഫ്റ്റ്‌വെയർ, ഇൻഫർമേഷൻ ടെക്നോളജി, വിദേശ വ്യാപാരം, ഇലക്ട്രോണിക്സ്, മാധ്യമങ്ങൾ, ഗവേഷണം, നൂതന സംരംഭങ്ങൾ എന്നീ മേഖലകളിൽ അത്ഭുതകരമായ വിജയം കൈവരിക്കും. വിദേശബന്ധങ്ങളും ധീരമായ തീരുമാനങ്ങളും സാമ്പത്തിക അഭിവൃദ്ധി നൽകും.',
                'ta' => 'மென்பொருள் துறை, செயற்கை நுண்ணறிவு, வெளிநாட்டு வர்த்தகம், ஊடகம், துப்பறிவு மற்றும் ஸ்டார்ட்-அப் தொழில்களில் பிரம்மாண்ட வெற்றி அடைவீர்கள். துணிச்சலான முதலீடுகள் உங்கள் அந்தஸ்தை உயர்த்தும்.',
                'hi' => 'सॉफ्टवेयर, आईटी, आर्टिफिशियल इंटेलिजेंस, विदेशी व्यापार, मीडिया, शोध और स्टार्टअप्स में आपका भविष्य अत्यधिक सफल रहेगा। साहसिक निर्णय आपको अकूत सफलता और उन्नति दिलाएंगे।',
            ],
            'relationship_prediction' => [
                'en' => 'You seek an unconventional partner who respects your intellectual independence and unique worldview. Mutual freedom and honest communication form the bedrocks of your marital stability.',
                'ml' => 'സ്വന്തം ചിന്തകൾക്കും സ്വാതന്ത്ര്യത്തിനും പ്രാധാന്യം നൽകുന്ന ജീവിതപങ്കാളിയെയാണ് താങ്കൾ തിരഞ്ഞെടുക്കേണ്ടത്. മനസ്സുതുറന്നുള്ള ആശയവിനിമയത്തിലൂടെ തെറ്റിദ്ധാരണകൾ ഒഴിവാക്കിയാൽ സന്തോഷകരമായ കുടുംബജീവിതം നയിക്കാം.',
                'ta' => 'உங்களின் சுதந்திரமான சிந்தனையைப் புரிந்து கொள்ளும் வாழ்க்கைத் துணையே உங்களுக்குப் பொருத்தமானவர். மனந்திறந்து பேசுவதும், பரஸ்பர நம்பிக்கையும் உங்கள் இல்லறத்தை இனியதாக்கும்.',
                'hi' => 'आप एक ऐसे जीवनसाथी की तलाश में रहते हैं जो आपकी बौद्धिक स्वतंत्रता का सम्मान करे। खुला संवाद और एक-दूसरे के विचारों का आदर आपके दांपत्य को सुदृढ़ बनाएगा।',
            ],
            'health_prediction' => [
                'en' => 'Rahu influences the nervous system, unexpected health fluctuations, and sleep patterns. Ground yourself through barefoot walking on soil/grass, practice deep pranayama, and maintain regular meal schedules.',
                'ml' => 'രാഹു ഞരമ്പുകളെയും മാനസിക പിരിമുറുക്കങ്ങളെയും ബാധിക്കാം. കൃത്യസമയത്ത് ഉറങ്ങാനും ആഹാരം കഴിക്കാനും ശ്രദ്ധിക്കുക. പ്രകൃതിയുമായി ഇണങ്ങി ജീവിക്കുന്നതും പ്രാണായാമം ശീലിക്കുന്നതും ആരോഗ്യം മെച്ചപ്പെടുത്തും.',
                'ta' => 'நரம்பு மண்டலம் மற்றும் தூக்கமின்மை ஏற்படாமல் கவனமாக இருக்கவும். புல்வெளியில் வெறுங்காலுடன் நடப்பதும், பிராணாயாமப் பயிற்சியும் மன அமைதியைத் தரும்.',
                'hi' => 'राहु तंत्रिका तंत्र (नर्वस सिस्टम) और अनिद्रा को प्रभावित कर सकता है। प्रतिदिन मिट्टी या घास पर नंगे पैर टहलें और प्राणायाम करें। भोजन का समय नियमित रखें।',
            ],
            'doctor_remedy' => [
                'en' => 'Worship Goddess Durga or Lord Sarpa Raja on Tuesdays and Fridays. Light a ghee lamp at a temple or chant the Durga Saptashloki to dissolve all obstacles and illuminate your path.',
                'ml' => 'ചൊവ്വ, വെള്ളി ദിവസങ്ങളിൽ സർപ്പക്ഷേത്രങ്ങളിലോ ദുർഗ്ഗാക്ഷേത്രങ്ങളിലോ ദർശനം നടത്തുക. ദുർഗ്ഗാസ്തുതി ജപിക്കുന്നതും നാഗങ്ങൾക്ക് നൂറും പാലും സമർപ്പിക്കുന്നതും സർവ്വതടസ്സങ്ങളും നീക്കി വിജയം തരും.',
                'ta' => 'செவ்வாய் மற்றும் வெள்ளிக்கிழமைகளில் துர்க்கை அல்லது நாகராஜரை வழிபடவும். நெய் தீபமிட்டு துர்க்கை கவசம் பாராயணம் செய்வது சகல தோஷங்களையும் நீக்கி வெற்றியைத் தரும்.',
                'hi' => 'मंगलवार और शुक्रवार को माँ दुर्गा या नाग देवता की पूजा करें। घी का दीपक जलाकर दुर्गा सप्तश्लोकी का पाठ करने से सभी बाधाएं दूर होती हैं और मार्ग प्रशस्त होता है।',
            ],
        ],
        5 => [
            'en' => 'Budha (Mercury)',
            'ml' => 'ബുധൻ (Budha)',
            'ta' => 'புதன் (Budhan)',
            'hi' => 'बुध (Budha)',
            'archetype' => [
                'en' => 'The Eloquent Prince & Intellectual Dynamo (ബുദ്ധിമാൻ)',
                'ml' => 'ബുദ്ധിമാനും വാഗ്മിയുമായ യുവരാജാവ് (The Eloquent Dynamo)',
                'ta' => 'சொல்வன்மை மிக்க புத்திசாலி (The Eloquent Dynamo)',
                'hi' => 'कुशाग्र बुद्धि और कुशल वक्ता (The Eloquent Dynamo)',
            ],
            'deity' => [
                'en' => 'Lord Maha Vishnu',
                'ml' => 'ശ്രീ മഹാവിഷ്ണു ഭഗവാൻ',
                'ta' => 'ஸ்ரீ மகாவிஷ்ணு பகவான்',
                'hi' => 'भगवान श्री महाविष्णु',
            ],
            'element' => [
                'en' => 'Earth / Intellect (പൃഥ്വി / വാക്ക്)',
                'ml' => 'ഭൂമി / ബുദ്ധി (വാക്ശക്തി)',
                'ta' => 'பூமி / புத்தி (வாக் சாதுரியம்)',
                'hi' => 'पृथ्वी / बुद्धि (वाक शक्ति)',
            ],
            'traits' => [
                'en' => 'Sharp analytical agility, razor-sharp eloquence, trade brilliance, multi-tasking mastery, and youthful charm.',
                'ml' => 'തീക്ഷ്ണമായ ബുദ്ധിശക്തി, പ്രഭാഷണപാടവം, വ്യാപാരസാമർത്ഥ്യം, വാക്ചാതുർ്യം, യുവത്വത്തിന്റെ പ്രസരിപ്പ്.',
                'ta' => 'கூர்மையான பகுப்பாய்வுத் திறன், பேச்சுத் திறமை, வியாபார தந்திரம், பன்முகத் திறன், புத்துணர்ச்சி.',
                'hi' => 'तीक्ष्ण विश्लेषण क्षमता, वाकपटुता, व्यापारिक दक्षता, बहुमुखी प्रतिभा और सदाबहार आकर्षण।',
            ],
            'gemstone_en' => 'Emerald (Marathakam)',
            'gemstone_ml' => 'മരതകം (Natural Zambian / Colombian Emerald)',
            'gemstone_ta' => 'மரகதம் (Emerald)',
            'gemstone_hi' => 'पन्ना (Emerald)',
            'wearing_rule' => [
                'en' => 'Wear in Gold or Bronze on the Little (Kanishthika) Finger on a Wednesday morning.',
                'ml' => 'ബുധനാഴ്ച രാവിലെ സ്വർണ്ണത്തിലോ വെങ്കലത്തിലോ ചെറുവിരലിൽ (കനിഷ്ഠിക) ധരിക്കുക.',
                'ta' => 'புதன்கிழமை காலையில் தங்கம் அல்லது வெண்கலத்தில் சுண்டு விரலில் அணியவும்.',
                'hi' => 'बुधवार की सुबह सोने या कांसे में कनिष्ठिका (सबसे छोटी) अंगुली में धारण करें।',
            ],
            'lucky_color' => [
                'en' => 'Emerald Green, Mint, Jade, Leaf Green',
                'ml' => 'മരതകപ്പച്ച, ഇലപ്പച്ച, മിന്റ് ഗ്രീൻ',
                'ta' => 'மரகத பச்சை, கிளிப்பச்சை, இலைப்பச்சை',
                'hi' => 'पन्ना हरा, तोतिया हरा, हल्का हरा',
            ],
            'lucky_day' => [
                'en' => 'Wednesday (ബുധനാഴ്ച)',
                'ml' => 'ബുധനാഴ്ച (Wednesday)',
                'ta' => 'புதன்கிழமை (Wednesday)',
                'hi' => 'बुधवार (Wednesday)',
            ],
            'lucky_numbers' => '5, 14, 23 (harmonious with all numbers)',
            'favorable_direction' => [
                'en' => 'North (വടക്ക് - Kubera Sthanam)',
                'ml' => 'വടക്ക് (North - കുബേരസ്ഥാനം)',
                'ta' => 'வடக்கு (குபேர மூலை)',
                'hi' => 'उत्तर (कुबेर स्थान - धन की दिशा)',
            ],
            'mantra_sanskrit' => 'ॐ ब्रां ब्रीं ब्रौं सः बुधाय नमः ॥',
            'mantra_translit' => 'Om Braam Breem Broum Sah Budhaaya Namah',
            'personality_prediction' => [
                'en' => 'Governed by Budha (the celestial prince of intellect and speech), your mental faculties are quick, observant, and adaptable. You possess a youthful spirit, an infectious sense of humor, and an insatiable curiosity. You can analyze complex situations in seconds and communicate ideas with persuasive grace.',
                'ml' => 'ബുദ്ധിയുടെ കാരകനായ ബുധഭഗവാന്റെ അനുഗ്രഹമുള്ള താങ്കൾ അപാരമായ ഗ്രഹണശക്തിയും വാക്സാമർത്ഥ്യവുമുള്ള വ്യക്തിയാണ്. സരസമായ സംഭാഷണശൈലിയും പുതിയ കാര്യങ്ങൾ വേഗത്തിൽ പഠിച്ചെടുക്കാനുള്ള കഴിവും താങ്കളുടെ മുഖമുദ്രയാണ്. ഏത് പ്രതിസന്ധിയിലും ബുദ്ധിപൂർവ്വം ചിന്തിച്ച് അനുയോജ്യമായ പരിഹാരം കണ്ടെത്താൻ സാധിക്കും.',
                'ta' => 'புத்தி காரகனான புதனின் ஆசியால் நீங்கள் சுறுசுறுப்பான மனதும், சிறந்த நாவன்மையும் கொண்டவர். நகைச்சுவை உணர்வும், எதையும் எளிதில் கற்றுக் கொள்ளும் ஆர்வமும் உங்களிடம் உண்டு. எப்பேர்ப்பட்ட கடினமான சூழலையும் உங்கள் சமயோசித புத்தியால் சுமுகமாக மாற்றிவிடுவீர்கள்.',
                'hi' => 'बुद्धिमत्ता और वाणी के स्वामी बुध देव के प्रभाव से आपका मस्तिष्क अत्यंत तीव्र और अनुकूलनशील है। आपमें स्वाभाविक हास्यबोध और सीखने की तीव्र जिज्ञासा है। आप जटिल से जटिल समस्याओं को पलक झपकते हल करने और अपनी बात दूसरों से मनवाने में माहिर हैं।',
            ],
            'career_prediction' => [
                'en' => 'Thrives in commerce, financial trading, data science, software development, marketing, journalism, writing, public speaking, and logistics. You have the rare gift of turning words and ideas into tangible commercial success.',
                'ml' => 'വ്യാപാരം, വാണിജ്യം, ധനകാര്യം, ഡാറ്റാ സയൻസ്, സോഫ്റ്റ്‌വെയർ, മാർക്കറ്റിംഗ്, മാധ്യമപ്രവർത്തനം, സാഹിത്യം, അക്കൗണ്ടിംഗ് എന്നീ മേഖലകളിൽ താങ്കൾ വലിയ വിജയം കൈവരിക്കും. സംസാരത്തെയും ആശയങ്ങളെയും ധനസമ്പാദനമാക്കി മാറ്റാനുള്ള അപൂർവ്വസിദ്ധി താങ്കൾക്കുണ്ട്.',
                'ta' => 'வணிகம், பங்குச்சந்தை, நிதித்துறை, மென்பொருள், விளம்பரம், பத்திரிகை, எழுத்து, சொற்பொழிவு ஆகியவற்றில் பெரும் வெற்றி கிட்டும். உங்கள் சொல்லாற்றல் உங்களுக்குப் பெரும் செல்வத்தைத் தேடித் தரும்.',
                'hi' => 'व्यापार, शेयर बाजार, बैंकिंग, डेटा साइंस, सॉफ्टवेयर, मार्केटिंग, पत्रकारिता, लेखन और वकालत में आपका करियर ऊंचाइयों को छूएगा। आपके पास अपने शब्दों और विचारों को आर्थिक सफलता में बदलने का हुनर है।',
            ],
            'relationship_prediction' => [
                'en' => 'You value witty banter, intellectual alignment, and lively companionship. Routine bores you; keep relationships dynamic with shared journeys, cultural explorations, and thoughtful conversations.',
                'ml' => 'സൗഹൃദപരമായ സമീപനവും ബുദ്ധിപരമായ ആശയവിനിമയവുമാണ് ദാമ്പത്യത്തിൽ താങ്കൾ ഇഷ്ടപ്പെടുന്നത്. വിരസത ഒഴിവാക്കാൻ പങ്കാളിയുമൊത്ത് യാത്രകൾ നടത്തുകയും കുടുംബകാര്യങ്ങൾ ഒരുമിച്ച് ചർച്ച ചെയ്യുകയും ചെയ്യുന്നത് സ്നേഹം നിലനിർത്തും.',
                'ta' => 'உறவுமுறைகளில் எப்போதும் புத்துணர்ச்சியையும், அறிவுப்பூர்வமான பகிர்வையும் விரும்புவீர்கள். வழக்கமான வாழ்க்கையை விட துணையுடன் மகிழ்ச்சியான பயணங்கள் மேற்கொள்வதும், மனம்விட்டுப் பேசுவதும் தாம்பத்தியத்தை சிறக்க வைக்கும்.',
                'hi' => 'आप रिश्तों में जीवंतता, हंसी-मजाक और बौद्धिक समानता पसंद करते हैं। एकरसता से बचने के लिए जीवनसाथी के साथ नए स्थानों का भ्रमण करें और विचार साझा करें।',
            ],
            'health_prediction' => [
                'en' => 'Budha governs the nervous system, vocal cords, respiratory tract, and skin. Prevent mental fatigue by practicing regular digital detoxes and consuming Brahmi or green leafy vegetables.',
                'ml' => 'ബുധൻ നാഡീവ്യൂഹം, ത്വക്ക്, ശ്വാസകോശം എന്നിവയെ നിയന്ത്രിക്കുന്നു. അമിതമായ ചിന്തകളും മൊബൈൽ ഫോൺ ഉപയോഗവും കുറയ്ക്കുക. ബ്രഹ്മി നെയ്യ്, പച്ചക്കറികൾ എന്നിവ ആഹാരത്തിൽ ഉൾപ്പെടുത്തുന്നത് ബുദ്ധിക്കും ആരോഗ്യത്തിനും ഉത്തമമാണ്.',
                'ta' => 'புதன் நரம்பு மண்டலம், குரல்வளை மற்றும் சருமத்தைக் குறிக்கிறது. அதிக மன உளைச்சலைத் தவிர்க்கவும். கீரை வகைகள் மற்றும் பிராமி நெய் உண்பது நரம்புகளுக்கு வலுவூட்டும்.',
                'hi' => 'बुध देव तंत्रिका तंत्र, वाणी और त्वचा के स्वामी हैं। अधिक मानसिक थकान से बचें। हरी पत्तेदार सब्जियां, ब्राह्मी और तुलसी का सेवन आपको ऊर्जावान रखेगा।',
            ],
            'doctor_remedy' => [
                'en' => 'Chant Vishnu Sahasranama on Wednesdays. Feed green fodder to cows and plant green trees to attract the abundant blessings of Lord Budha.',
                'ml' => 'ബുധനാഴ്ചകളിൽ വിഷ്ണുസഹസ്രനാമം ജപിക്കുക. തുളസിത്തറയിൽ നെയ്യ് വിളക്ക് കൊളുത്തുക, പശുക്കൾക്ക് പച്ചപ്പുല്ല് നൽകുക, വൃക്ഷങ്ങൾ നട്ടുപിടിപ്പിക്കുക എന്നിവ ബുധപ്രീതിക്ക് അത്യുത്തമമാണ്.',
                'ta' => 'புதன்கிழமைகளில் விஷ்ணு சகஸ்ரநாமம் பாராயணம் செய்யவும். பசுவுக்கு பசும்புல் அளிப்பதும், மரக்கன்றுகள் நடுவதும் புதன் பகவானின் அருள்மழையை வாரி வழங்கும்.',
                'hi' => 'बुधवार को विष्णु सहस्रनाम का पाठ करें। गाय को हरा चारा खिलाएं और तुलसी का पौधा लगाएं। इससे बुध देव का आशीर्वाद प्राप्त होता है।',
            ],
        ],
        6 => [
            'en' => 'Shukra (Venus)',
            'ml' => 'ശുക്രൻ (Shukra)',
            'ta' => 'சுக்கிரன் (Sukran)',
            'hi' => 'शुक्र (Shukra)',
            'archetype' => [
                'en' => 'The Refined Aesthetician & Magnet of Luxury (സൗന്ദര്യോപാസകൻ)',
                'ml' => 'സൗന്ദര്യോപാസകനും ഐശ്വര്യദാതാവും (The Aesthetic Master)',
                'ta' => 'கலை ரசிகர் மற்றும் சுகபோக அதிபதி (The Aesthetic Master)',
                'hi' => 'सौंदर्य प्रेमी और वैभव के अधिपति (The Aesthetic Master)',
            ],
            'deity' => [
                'en' => 'Goddess Mahalakshmi / Shukracharya',
                'ml' => 'ശ്രീ മഹാലക്ഷ്മീദേവി / ശുക്രാചാര്യൻ',
                'ta' => 'ஸ்ரீ மஹாலக்ஷ்மி தேவி / சுக்கிராச்சாரியார்',
                'hi' => 'माँ महालक्ष्मी / शुक्राचार्य',
            ],
            'element' => [
                'en' => 'Water / Creative Elixir (അമൃതം / സൗന്ദര്യം)',
                'ml' => 'ജലം / സൗന്ദര്യകല (കലാതത്ത്വം)',
                'ta' => 'நீர் / கலை நயம் (சுகபோக தத்துவம்)',
                'hi' => 'जल / कलात्मक आकर्षण (कला तत्व)',
            ],
            'traits' => [
                'en' => 'Refined aesthetic taste, magnetic charisma, artistic elegance, diplomatic tact, and natural affinity for prosperity.',
                'ml' => 'കലാപരമായ അഭിരുചി, വശ്യമായ ആകർഷകത്വം, സൗന്ദര്യബോധം, സൗമ്യത, ഐശ്വര്യ സമൃദ്ധി.',
                'ta' => 'கலை ஆர்வம், வசீகரமான தோற்றம், நளினமான பண்பு, விவேகம், சுகபோகங்களை அனுபவிக்கும் யோகம்.',
                'hi' => 'परिष्कृत सौंदर्यबोध, चुंबकीय आकर्षण, कलात्मक लालित्य, शिष्टता और स्वाभाविक समृद्धि।',
            ],
            'gemstone_en' => 'Diamond (Vajram) / White Zircon',
            'gemstone_ml' => 'വജ്രം (Natural Diamond / White Zircon)',
            'gemstone_ta' => 'வைரம் (Natural Diamond / White Zircon)',
            'gemstone_hi' => 'हीरा (Diamond / White Zircon)',
            'wearing_rule' => [
                'en' => 'Wear in Platinum, White Gold, or Silver on the Middle or Ring Finger on a Friday morning.',
                'ml' => 'വെള്ളിയാഴ്ച രാവിലെ പ്ലാറ്റിനം, വെള്ളത്തങ്കം അല്ലെങ്കിൽ വെള്ളിയിൽ മോതിരവിരലിലോ നടുവിരലിലോ ധരിക്കുക.',
                'ta' => 'வெள்ளிக்கிழமை காலையில் பிளாட்டினம் அல்லது வெள்ளியில் மோதிர விரலில் அணியவும்.',
                'hi' => 'शुक्रवार की सुबह प्लैटिनम, सफेद सोने या चांदी में अनामिका या मध्यमा अंगुली में धारण करें।',
            ],
            'lucky_color' => [
                'en' => 'Diamond White, Sparkling Cream, Pastel Pink, Silver',
                'ml' => 'വെളുപ്പ്, ഇളം പിങ്ക്, ക്രീം, വെള്ളി നിറം',
                'ta' => 'பளபளக்கும் வெள்ளை, இளஞ்சிவப்பு, கிரீம், வெள்ளி',
                'hi' => 'चमकीला सफेद, हल्का गुलाबी, क्रीम, सिल्वर',
            ],
            'lucky_day' => [
                'en' => 'Friday (വെള്ളിയാഴ്ച)',
                'ml' => 'വെള്ളിയാഴ്ച (Friday)',
                'ta' => 'வெள்ளிக்கிழமை (Friday)',
                'hi' => 'शुक्रवार (Friday)',
            ],
            'lucky_numbers' => '6, 15, 24 (supportive: 5, 8)',
            'favorable_direction' => [
                'en' => 'Southeast (അഗ്നികോൺ - Agni Konam)',
                'ml' => 'തെക്ക്-കിഴക്ക് (അഗ്നികോൺ)',
                'ta' => 'தென்கிழக்கு (அக்னி மூலை)',
                'hi' => 'आग्नेय कोण (दक्षिण-पूर्व दिशा)',
            ],
            'mantra_sanskrit' => 'ॐ द्रां द्रीं द्रौं सः शुक्राय नमः ॥',
            'mantra_translit' => 'Om Draam Dreem Droum Sah Shukraaya Namah',
            'personality_prediction' => [
                'en' => 'Ruled by Shukra Deva, your aura radiates charm, refinement, and peaceful harmony. You have an eye for beauty, luxury, high culture, and genuine hospitality. You naturally defuse conflict with grace and bring celebration wherever you go.',
                'ml' => 'ഭൗതിക സുഖങ്ങളുടെയും സൗന്ദര്യത്തിന്റെയും കാരകനായ ശുക്രന്റെ അനുഗ്രഹമുള്ള താങ്കൾ പ്രസന്നമായ വ്യക്തിത്വത്തിന് ഉടമയാണ്. ഏവരുടെയും മനംകവരുന്ന രൂപഭംഗിയും പെരുമാറ്റശൈലിയും താങ്കൾക്കുണ്ട്. കല, വസ്ത്രധാരണം, അലങ്കാരം, സുഖസൗകര്യങ്ങൾ എന്നിവയിൽ ഉയർന്ന നിലവാരം പുലർത്തും.',
                'ta' => 'சுகபோக காரகனான சுக்கிரனின் ஆசியால் நீங்கள் வசீகரமான அழகும், இன்முகமும், கலை தாகமும் கொண்டவர். ஆடம்பரம், நேர்த்தி மற்றும் ஆடைகளில் சிறந்த ரசனை உண்டு. பகைமையையும் அன்பால் வெல்லும் ஆற்றல் படைத்தவர்.',
                'hi' => 'शुक्र देव के प्रभाव से आपके व्यक्तित्व में सम्मोहन, शालीनता और सौहार्द है। आपमें कला, फैशन, सुरुचिपूर्ण जीवनशैली और आतिथ्य सत्कार की स्वाभाविक प्रतिभा है। आप जहां भी जाते हैं, वहां आनंद और सुंदरता बिखेरते हैं।',
            ],
            'career_prediction' => [
                'en' => 'Excels in fashion, interior design, luxury automobiles, hospitality, cinema, music, jewelry, cosmetics, fine dining, architecture, and international branding. You turn visual elegance into high financial prosperity.',
                'ml' => 'ഫാഷൻ, ഇന്റീരിയർ ഡിസൈനിംഗ്, സിനിമ, സംഗീതം, ജ്വല്ലറി, കോസ്മെറ്റിക്സ്, ലക്ഷ്വറി ഓട്ടോമൊബൈൽ, ഹോസ്പിറ്റാലിറ്റി, ടൂറിസം എന്നീ മേഖലകളിൽ ഉന്നത വിജയം നേടും. സൗന്ദര്യവും ആകർഷണീയതയും മുൻനിർത്തിയുള്ള സംരംഭങ്ങൾ വലിയ ലാഭം നൽകും.',
                'ta' => 'ஆடை வடிவமைப்பு, ஆபரணத் தொழில், திரைப்படம், இசை, சுற்றுலா, உணவகம், அழகு சாதனங்கள் மற்றும் கலைத் துறைகளில் கோலோச்சுவீர்கள். உங்களின் ரசனை உங்களுக்குப் பெரும் செல்வாக்கைத் தரும்.',
                'hi' => 'फैशन, इंटीरियर डिजाइनिंग, सिनेमा, संगीत, आभूषण, कॉस्मेटिक्स, होटल, टूरिज्म और लक्जरी ब्रांड्स में आपका करियर बेमिसाल रहेगा। सौंदर्य और कला से जुड़े व्यवसाय में आपको अपार धन लाभ होगा।',
            ],
            'relationship_prediction' => [
                'en' => 'Love and romance are central pillars of your happiness. You treat relationships as sacred works of art, showering your beloved with affection and elegance. Keep unrealistic romantic fantasies grounded in practical life.',
                'ml' => 'പ്രണയത്തെയും കുടുംബജീവിതത്തെയും അതീവ പവിത്രതയോടെ കാണുന്ന വ്യക്തിയാണ് താങ്കൾ. പങ്കാളിക്ക് എല്ലാവിധ സുഖസൗകര്യങ്ങളും സ്നേഹവും താങ്കൾ നൽകും. എങ്കിലും അമിതമായ പ്രതീക്ഷകൾ ഒഴിവാക്കി യാഥാർത്ഥ്യബോധത്തോടെ ജീവിക്കുന്നത് ദാമ്പത്യം കൂടുതൽ ദൃഢമാക്കും.',
                'ta' => 'காதலும் தாம்பத்தியமும் உங்கள் வாழ்வின் முக்கியமான இன்பங்கள். வாழ்க்கைத் துணையை அன்பாலும் பரிசுகளாலும் மகிழ்விப்பீர்கள். நடைமுறை எதார்த்தத்தை உணர்ந்து நடப்பது குடும்பத்தில் என்றும் அமைதியைத் தரும்.',
                'hi' => 'प्रेम और वैवाहिक सुख आपके जीवन का मुख्य आधार हैं। आप अपने जीवनसाथी को भरपूर स्नेह और सुख-सुविधाएं प्रदान करते हैं। अत्यधिक काल्पनिक अपेक्षाओं से बचकर यथार्थवादी बने रहना दांपत्य को अमर बनाएगा।',
            ],
            'health_prediction' => [
                'en' => 'Venus governs reproductive vitality, kidneys, urinary system, and skin radiance. Stay well hydrated, minimize refined sugar intake, and balance your lifestyle with adequate rest.',
                'ml' => 'ശുക്രൻ വൃക്കകൾ, ചർമ്മം, പ്രജനന വ്യവസ്ഥ എന്നിവയെ നിയന്ത്രിക്കുന്നു. പഞ്ചസാരയുടെ ഉപയോഗം കുറയ്ക്കുക, ധാരാളം ശുദ്ധജലം കുടിക്കുക, കൃത്യമായ ഉറക്കം ശീലിക്കുക എന്നിവ യൗവനവും ആരോഗ്യവും നിലനിർത്തും.',
                'ta' => 'சுக்கிரன் சிறுநீரகம் மற்றும் சரும அழகைக் குறிக்கிறது. அதிக சர்க்கரை உணவுகளைத் தவிர்க்கவும். போதிய அளவு தண்ணீர் குடிப்பது உடலை எப்போதும் பொலிவுடன் வைக்கும்.',
                'hi' => 'शुक्र देव गुर्दे (किडनी), त्वचा की चमक और जीवन शक्ति का प्रतिनिधित्व करते हैं। पर्याप्त पानी पिएं और अधिक मीठे से बचें। नियमित दिनचर्या से आपका आकर्षण बना रहेगा।',
            ],
            'doctor_remedy' => [
                'en' => 'Worship Goddess Mahalakshmi on Fridays. Recite the Kanakadhara Stotram and offer white sweets or kheer to young girls or the needy for unstoppable prosperity.',
                'ml' => 'വെള്ളിയാഴ്ചകളിൽ മഹാലക്ഷ്മീ ക്ഷേത്ര ദർശനം നടത്തുക, കനകധാരാ സ്തോത്രം ജപിക്കുക. സന്ധ്യാസമയത്ത് നെയ്യ് വിളക്ക് കൊളുത്തുകയും വെളുത്ത മധുരപലഹാരങ്ങൾ അല്ലെങ്കിൽ പാൽപ്പായസം ദേവിക്ക് നിവേദിക്കുകയും ചെയ്യുക.',
                'ta' => 'வெள்ளிக்கிழமைகளில் மகாலட்சுமிக்கு நெய் தீபமிட்டு கனகதாரா ஸ்தோத்திரம் பாராயணம் செய்யவும். வெள்ளியன்று ஏழைகளுக்கு பால் பாயசம் அல்லது இனிப்பு தானம் செய்வது லட்சுமி கடாட்சத்தை அள்ளித்தரும்.',
                'hi' => 'शुक्रवार को माँ महालक्ष्मी की उपासना करें और कनकधारा स्तोत्र का पाठ करें। छोटी कन्याओं को खीर या सफेद मिठाई खिलाने से जीवन में कभी धन-वैभव की कमी नहीं होती।',
            ],
        ],
        7 => [
            'en' => 'Ketu (South Node of Moon)',
            'ml' => 'കേതു (Ketu)',
            'ta' => 'கேது (Kethu)',
            'hi' => 'केतु (Ketu)',
            'archetype' => [
                'en' => 'The Mystic Seer & Intuitive Philosopher (തത്വജ്ഞാനി)',
                'ml' => 'തത്വജ്ഞാനിയും ആത്മീയ ദാർശനികനും (The Mystic Seer)',
                'ta' => 'ஞான மோட்ச தத்துவஞானி (The Mystic Seer)',
                'hi' => 'रहस्यदर्शी और आत्मज्ञानी तपस्वी (The Mystic Seer)',
            ],
            'deity' => [
                'en' => 'Lord Ganesha / Matsya Avatar',
                'ml' => 'ശ്രീ ഗണപതി ഭഗവാൻ / മത്സ്യാവതാരം',
                'ta' => 'ஸ்ரீ விநாயகப் பெருமான் / மச்ச அவதாரம்',
                'hi' => 'भगवान श्री गणेश / मत्स्य अवतार',
            ],
            'element' => [
                'en' => 'Ether / Transcendental Fire (മോക്ഷാഗ്നി)',
                'ml' => 'മോക്ഷാഗ്നി / ആത്മീയജ്ഞാനം (ആത്മതത്ത്വം)',
                'ta' => 'மோட்ச நெருப்பு / ஆன்மீக ஞானம்',
                'hi' => 'मोक्ष तत्व / आध्यात्मिक अग्नि',
            ],
            'traits' => [
                'en' => 'Profound spiritual depth, penetrating intuition, detachment from superficiality, philosophical originality, and research acumen.',
                'ml' => 'ആത്മീയ ഔന്നത്യം, അതീന്ദ്രിയ ജ്ഞാനം, ബാഹ്യമോഹങ്ങളിൽ നിന്നുള്ള വിരക്തി, ആഴത്തിലുള്ള ഗവേഷണബുദ്ധി.',
                'ta' => 'ஆன்மீக நாட்டம், ஊடுருவிப் பார்க்கும் உள்ளுணர்வு, உலக மாயைகளில் விலகல், தீவிர ஆராய்ச்சி மனப்பான்மை.',
                'hi' => 'गहन आध्यात्मिक गहराई, भेदक अंतर्दृष्टि, सांसारिक दिखावे से विरक्ति, मौलिक चिंतन और शोध क्षमता।',
            ],
            'gemstone_en' => 'Cat’s Eye (Vaidooryam)',
            'gemstone_ml' => 'വൈഡൂര്യം (Natural Chrysoberyl Cat’s Eye)',
            'gemstone_ta' => 'வைடூரியம் (Cat’s Eye)',
            'gemstone_hi' => 'लहसुनिया (Cat’s Eye)',
            'wearing_rule' => [
                'en' => 'Wear in Silver on the Little or Middle Finger on a Tuesday or Thursday evening.',
                'ml' => 'ചൊവ്വാഴ്ചയോ വ്യാഴാഴ്ചയോ സന്ധ്യയ്ക്ക് ശുദ്ധമായ വെള്ളിയിൽ നടുവിരലിലോ ചെറുവിരലിലോ ധരിക്കുക.',
                'ta' => 'செவ்வாய் அல்லது வியாழக்கிழமை மாலை வேளையில் வெள்ளியில் சுண்டு விரலில் அணியவும்.',
                'hi' => 'मंगलवार या गुरुवार की शाम को चांदी में कनिष्ठिका या मध्यमा अंगुली में धारण करें।',
            ],
            'lucky_color' => [
                'en' => 'Smoky Green, Grey, Multi-colored Earth tones',
                'ml' => 'ചാരനിറം, പുകപച്ച, മണ്ണിന്റെ നിറങ്ങൾ',
                'ta' => 'சாம்பல் பச்சை, மண் நிறம், பலவண்ணக் கலவை',
                'hi' => 'धूम्र हरा, स्लेटी, मिट्टी जैसा भूरा',
            ],
            'lucky_day' => [
                'en' => 'Tuesday / Thursday (ചൊവ്വ / വ്യാഴം)',
                'ml' => 'ചൊവ്വ, വ്യാഴം (Tue / Thu)',
                'ta' => 'செவ்வாய், வியாழன் (Tue / Thu)',
                'hi' => 'मंगलवार / गुरुवार (Tue / Thu)',
            ],
            'lucky_numbers' => '7, 16, 25 (supportive: 2, 4)',
            'favorable_direction' => [
                'en' => 'Northwest / Northeast (വായു / ഈശാന)',
                'ml' => 'വടക്ക്-പടിഞ്ഞാറ് / ഈശാനം',
                'ta' => 'வடமேற்கு / வடகிழக்கு',
                'hi' => 'वायव्य एवं ईशान कोण',
            ],
            'mantra_sanskrit' => 'ॐ स्रां स्रीं स्रौं सः केतवे नमः ॥',
            'mantra_translit' => 'Om Sraam Sreem Sroum Sah Ketave Namah',
            'personality_prediction' => [
                'en' => 'Influenced by Ketu, the planet of Moksha and esoteric insight, you see beyond material veils. You are guided by quiet gut instincts that rarely mislead you. You cherish solitude, deep inquiry, and authentic truth over noisy worldly flattery.',
                'ml' => 'മോക്ഷകാരകനായ കേതുവിന്റെ സ്വാധീനം താങ്കൾക്ക് അസാധാരണമായ ഉൾക്കാഴ്ചയും ആത്മീയ ചിന്തയും നൽകുന്നു. ഉപരിപ്ലവമായ ആർഭാടങ്ങളേക്കാൾ ശാന്തതയും ആത്മാർത്ഥതയുമാണ് താങ്കൾ ഇഷ്ടപ്പെടുന്നത്. സ്വന്തം മനസ്സാക്ഷിയെ വിശ്വസിച്ച് മുന്നേറിയാൽ അസാധ്യമായ കാര്യങ്ങൾ പോലും താങ്കൾക്ക് സാധിച്ചെടുക്കാം.',
                'ta' => 'ஞானகாரகனான கேதுவின் அருளால் நீங்கள் உலக ஆசைகளைத் தாண்டிய மேலான சிந்தனை கொண்டவர். உங்கள் உள்ளுணர்வு எப்போதும் உண்மையை முன்கூட்டியே உணர்த்தும். அமைதியான தனிமையிலும், தத்துவ ஆராய்ச்சிகளிலும் நிம்மதி காண்பீர்கள்.',
                'hi' => 'मोक्ष कारक केतु के प्रभाव से आपकी दृष्टि भौतिक आवरणों के पार देखने में सक्षम है। आपकी अंतरात्मा की आवाज आपको सदैव सही राह दिखाती है। आपको दिखावे से दूर एकांत, गंभीर चिंतन और सत्य की खोज प्रिय है।',
            ],
            'career_prediction' => [
                'en' => 'Superb in deep research, occult sciences, astrology, medicine, pharmaceuticals, software security, metaphysics, teaching, psychology, and spiritual writing. Your insights reveal answers where standard methods fail.',
                'ml' => 'ജ്യോതിഷം, ഗവേഷണം, ആയുർവേദം, മനഃശാസ്ത്രം, മെഡിസിൻ, സൈബർ സെക്യൂരിറ്റി, ആത്മീയ രചനകൾ, അധ്യാപനം എന്നീ രംഗങ്ങളിൽ താങ്കൾ പ്രശസ്തനാകും. നിഗൂഢമായ ശാസ്ത്രശാഖകളിൽ താങ്കൾക്ക് പെട്ടെന്ന് അറിവ് നേടാനാകും.',
                'ta' => 'ஆராய்ச்சி, ஜோதிடம், ஆன்மீகம், ஆயுர்வேதம், மருத்துவம், சைபர் செக்யூரிட்டி, மனோதத்துவம் மற்றும் தத்துவ நூல்கள் எழுதுவதில் புகழடைவீர்கள். மற்றவர்களுக்குத் தெரியாத ரகசியங்களை எளிதில் கண்டறிவீர்கள்.',
                'hi' => 'शोध, ज्योतिष, अध्यात्म, आयुर्वेद, औषधि विज्ञान, साइबर सुरक्षा, मनोविज्ञान और दर्शनशास्त्र में आपकी प्रतिभा अद्भुत चमक बिखेरती है। जहां साधारण तकनीक विफल होती है, वहां आपकी अंतर्दृष्टि हल निकालती है।',
            ],
            'relationship_prediction' => [
                'en' => 'You seek a soulful soulmate rather than mere social convenience. Expressing your emotions openly avoids inadvertent misunderstandings, cementing a deeply spiritual marital bond.',
                'ml' => 'ആത്മാർത്ഥമായ സ്നേഹബന്ധങ്ങളെയാണ് താങ്കൾ വിലമതിക്കുന്നത്. മനസ്സിലെ വിചാരങ്ങൾ ഉള്ളിലൊതുക്കാതെ പങ്കാളിയോട് തുറന്നു സംസാരിക്കുന്നത് ദാമ്പത്യത്തിൽ കൂടുതൽ അടുപ്പവും സമാധാനവും നൽകും.',
                'ta' => 'உள்ளத்தின் ஆழத்தில் உண்மையான பாசம் வைத்திருப்பீர்கள். மனதில் உள்ளதை வெளிப்படையாகப் பேசினால் தேவையற்ற சந்தேகங்கள் நீங்கி குடும்பத்தில் தெய்வீக மகிழ்ச்சி நிலவும்.',
                'hi' => 'आप केवल सामाजिक औपचारिकता नहीं, बल्कि आत्मिक संबंध चाहते हैं। अपनी भावनाओं को जीवनसाथी के समक्ष स्पष्ट व्यक्त करने से वैवाहिक बंधन आध्यात्मिक रूप से मजबूत होता है।',
            ],
            'health_prediction' => [
                'en' => 'Ketu governs spiritual energy, subtle body channels, allergies, and digestive sensitivity. Practice regular Pranayama and consume fresh, warm, Sattvic foods.',
                'ml' => 'കേതു സൂക്ഷ്മശരീരത്തെയും ഉദരസംബന്ധമായ പ്രവർത്തനങ്ങളെയും സ്വാധീനിക്കുന്നു. കൃത്യസമയത്ത് സാത്വികമായ ആഹാരം കഴിക്കുക. പ്രാണായാമവും ധ്യാനവും ശീലിക്കുന്നത് ആരോഗ്യത്തിന് ഉത്തമമാണ്.',
                'ta' => 'செரிமானக் கோளாறுகள் மற்றும் அலர்ஜியைத் தவிர்க்கவும். சுத்தமான சாத்விக உணவு, யோகா மற்றும் பிராணாயாமம் உடலுக்கும் ஆன்மாவிற்கும் பலம் சேர்க்கும்.',
                'hi' => 'केतु सूक्ष्म नाड़ियों, त्वचा की संवेदनशीलता और पाचन को प्रभावित करता है। ताजा, सात्विक भोजन ग्रहण करें और प्राणायाम का नित्य अभ्यास करें।',
            ],
            'doctor_remedy' => [
                'en' => 'Worship Lord Maha Ganapathi, the remover of obstacles, especially on Sankashti Chaturthi. Offer Karuka grass (Durva) and Modakas to Lord Ganesha to bestow supreme spiritual peace and success.',
                'ml' => 'വിഘ്നേശ്വരനായ ഗണപതിഭഗവാനെ നിത്യവും ഭജിക്കുക. ചതുർത്ഥി നാളുകളിൽ ഗണപതിക്ക് കറുകമാലയും മോദകവും സമർപ്പിക്കുക. ഇത് സർവ്വ വിഘ്നങ്ങളെയും അകറ്റി ശ്രേയസ്സ് നൽകും.',
                'ta' => 'விக்னங்களை நீக்கும் முழுமுதற் கடவுளான விநாயகப் பெருமானை சங்கடஹர சதுர்த்தியன்று வழிபடவும். அருகம்புல் சாற்றி வழிபட அனைத்துத் தடைகளும் சுக்குநூறாகும்.',
                'hi' => 'संकटनाशन गणेश स्तोत्र का पाठ करें। संकष्टी चतुर्थी पर भगवान गणेश को दूर्वा (दूब घास) और मोदक अर्पित करें। इससे सभी संकट दूर होते हैं और मानसिक शांति मिलती है।',
            ],
        ],
        8 => [
            'en' => 'Shani (Saturn)',
            'ml' => 'ശനി (Shani)',
            'ta' => 'சனி (Sani)',
            'hi' => 'शनि (Shani)',
            'archetype' => [
                'en' => 'The Monumental Builder & Pillar of Justice (കർമ്മശ്രേഷ്ഠൻ)',
                'ml' => 'കർമ്മശ്രേഷ്ഠനും നീതിപാലകനും (The Monumental Pillar)',
                'ta' => 'கர்ம யோகி மற்றும் நீதி அரசர் (The Pillar of Justice)',
                'hi' => 'कर्मयोगी और न्याय के दृढ़ स्तंभ (The Pillar of Justice)',
            ],
            'deity' => [
                'en' => 'Lord Shani Bhagavan / Lord Sastha (Ayyappa)',
                'ml' => 'ശ്രീ ധർമ്മശാസ്താവ് (അയ്യപ്പൻ) / ശനീശ്വരൻ',
                'ta' => 'ஸ்ரீ தர்ம சாஸ்தா (ஐயப்பன்) / சனீஸ்வர பகவான்',
                'hi' => 'भगवान शनि देव / धर्मशास्ता (अय्यप्पा)',
            ],
            'element' => [
                'en' => 'Air / Structural Foundation (വായു / ധർമ്മം)',
                'ml' => 'വായു / സ്ഥൈര്യം (സ്ഥിരതത്ത്വം)',
                'ta' => 'காற்று / வைராக்கியம் (நிலைத்தன்மை)',
                'hi' => 'वायु / स्थिरता (न्याय तत्व)',
            ],
            'traits' => [
                'en' => 'Unyielding perseverance, iron discipline, pragmatic wisdom, administrative stamina, and absolute fairness.',
                'ml' => 'അചഞ്ചലമായ ക്ഷമ, കഠിനാധ്വാനം, അച്ചടക്കം, നീതിബോധം, ഏത് പ്രതിസന്ധിയെയും മറികടക്കാനുള്ള മനക്കരുത്ത്.',
                'ta' => 'தளராத விடாமுயற்சி, கடும் உழைப்பு, இரும்பு போன்ற ஒழுக்கம், நேர்மை, சகிப்புத்தன்மை.',
                'hi' => 'अटूट धैर्य, कठोर अनुशासन, व्यावहारिक बुद्धिमत्ता, अथक परिश्रम और निष्पक्ष न्यायप्रियता।',
            ],
            'gemstone_en' => 'Blue Sapphire (Indraneelam)',
            'gemstone_ml' => 'ഇന്ദ്രനീലം (Natural Ceylon Blue Sapphire / Amethyst)',
            'gemstone_ta' => 'நீலக்கல் / இந்திரநீலம் (Blue Sapphire)',
            'gemstone_hi' => 'नीलम (Blue Sapphire / Amethyst)',
            'wearing_rule' => [
                'en' => 'Wear in Silver, White Gold, or Iron on the Middle (Madhyama) Finger on a Saturday evening.',
                'ml' => 'ശനിയാഴ്ച സന്ധ്യയ്ക്ക് വെള്ളിയിലോ ഇരുമ്പിലോ നടുവിരലിൽ (മധ്യവിരൽ) ധരിക്കുക.',
                'ta' => 'சனிக்கிழமை மாலை வேளையில் வெள்ளி அல்லது இரும்பில் நடுவிரலில் அணியவும்.',
                'hi' => 'शनिवार की शाम को चांदी या लोहे में मध्यमा (बीच की) अंगुली में धारण करें।',
            ],
            'lucky_color' => [
                'en' => 'Royal Blue, Navy, Dark Indigo, Black',
                'ml' => 'കടും നീല, നേവി ബ്ലൂ, കറുപ്പ്',
                'ta' => 'அடர் நீலம், கருநீலம், கருப்பு',
                'hi' => 'गहरा नीला, नेवी ब्लू, काला',
            ],
            'lucky_day' => [
                'en' => 'Saturday (ശനിയാഴ്ച)',
                'ml' => 'ശനിയാഴ്ച (Saturday)',
                'ta' => 'சனிக்கிழமை (Saturday)',
                'hi' => 'शनिवार (Saturday)',
            ],
            'lucky_numbers' => '8, 17, 26 (supportive: 5, 6)',
            'favorable_direction' => [
                'en' => 'West (പടിഞ്ഞാറ് - Varuna Sthanam)',
                'ml' => 'പടിഞ്ഞാറ് (West - വരുണസ്ഥാനം)',
                'ta' => 'மேற்கு (வருண மூலை)',
                'hi' => 'पश्चिम (वरुण स्थान)',
            ],
            'mantra_sanskrit' => 'ॐ प्रां प्रीं प्रौं सः शनैश्चराय नमः ॥',
            'mantra_translit' => 'Om Praam Preem Proum Sah Shanaishcharaaya Namah',
            'personality_prediction' => [
                'en' => 'Ruled by Shani, the lord of Karma and cosmic justice, your life is built on solid rock, not sand. You understand that true success requires perseverance, sacrifice, and ethical responsibility. While early life may present tests and delays, your mature years (post-age 35) bring monumental stability, respect, and lasting authority.',
                'ml' => 'കർമ്മഫലദാതാവായ ശനീശ്വരന്റെ അനുഗ്രഹമുള്ള താങ്കൾ കഠിനാധ്വാനത്തിലൂടെയും ത്യാഗത്തിലൂടെയും സ്വന്തം ജീവിതം പടുത്തുയർത്തുന്ന വ്യക്തിയാണ്. കുറുക്കുവഴികളിലൂടെയുള്ള വിജയത്തേക്കാൾ സത്യസന്ധമായ പ്രയത്നത്തിലാണ് താങ്കൾ വിശ്വസിക്കുന്നത്. ജീവിതത്തിന്റെ ആദ്യപകുതിയിൽ കഠിനമായ പരീക്ഷണങ്ങൾ നേരിടേണ്ടി വന്നാലും, 35 വയസ്സിനു ശേഷം താങ്കളുടെ അന്തസ്സും സാമ്പത്തിക ഭദ്രതയും അദ്ഭുതകരമായി ഉയരും.',
                'ta' => 'கர்மகாரகனான சனீஸ்வர பகவானின் அருளால் நீங்கள் பொறுமையும் கடின உழைப்பும் கொண்டவர். எதையும் குறுக்கு வழியில் அடைய விரும்பாமல், நியாயமாக உழைத்து வெல்வீர்கள். ஆரம்ப காலத்தில் சோதனைகள் வந்தாலும், 35 வயதுக்குப் பின் உங்கள் வாழ்க்கை நிலையான செல்வத்தோடும் பெரும் புகழோடும் ஒளிரும்.',
                'hi' => 'कर्मफलदाता शनि देव के प्रभाव से आपका जीवन किसी चट्टान की तरह मजबूत आधार पर निर्मित है। आप समझते हैं कि सच्ची सफलता त्याग और निरंतर परिश्रम से मिलती है। प्रारंभिक जीवन में संघर्ष भले रहे, किंतु 35 वर्ष की आयु के पश्चात आपको स्थायी प्रतिष्ठा, अधिकार और अकूत सम्मान प्राप्त होता है।',
            ],
            'career_prediction' => [
                'en' => 'Stands at the pinnacle of engineering, heavy industries, real estate, construction, law, corporate administration, judicial administration, oil & minerals, and governance. You build institutions that outlast generations.',
                'ml' => 'എൻജിനീയറിംഗ്, റിയൽ എസ്റ്റേറ്റ്, കൺസ്ട്രക്ഷൻ, നിയമം, വ്യവസായം, ഖനനം, പെട്രോളിയം, അഡ്മിനിസ്ട്രേഷൻ എന്നീ മേഖലകളിൽ താങ്കൾ വലിയ പദവികൾ അലങ്കരിക്കും. ദീർഘകാലാടിസ്ഥാനത്തിൽ നിലനിൽക്കുന്ന വൻ സ്ഥാപനങ്ങൾ കെട്ടിപ്പടുക്കാൻ താങ്കൾക്ക് സാധിക്കും.',
                'ta' => 'பொறியியல், கட்டுமானத்துறை, ரியல் எஸ்டேட், சட்டம், கனரகத் தொழில்கள், சுரங்கம், நிர்வாகம் ஆகியவற்றில் உச்சம் தொடுவீர்கள். தலைமுறை தாண்டி நிற்கும் மாபெரும் நிறுவனங்களை உருவாக்கும் திறன் உண்டு.',
                'hi' => 'इंजीनियरिंग, भारी उद्योग, रियल एस्टेट, निर्माण, कानून, न्यायपालिका, कॉर्पोरेट प्रशासन और शासन व्यवस्था में आप शीर्ष स्थान प्राप्त करते हैं। आप ऐसे संस्थानों की नींव रखते हैं जो पीढ़ियों तक चलते हैं।',
            ],
            'relationship_prediction' => [
                'en' => 'You are slow to open your heart, but once committed, your loyalty is indestructible. You take your family obligations with utmost seriousness. Cultivating expressions of joy and spontaneous affection enriches your domestic life.',
                'ml' => 'സ്നേഹം വാക്കുകളിലൂടെ പ്രകടിപ്പിക്കാൻ മടി കാട്ടുമെങ്കിലും, മനസ്സിൽ അടിയുറച്ച കൂറും ഉത്തരവാദിത്തവുമുള്ള വ്യക്തിയാണ് താങ്കൾ. കുടുംബത്തിന് തണലായി എന്നും നിലകൊള്ളും. മനസ്സ് തുറന്ന് സ്നേഹം പ്രകടിപ്പിക്കുന്നത് കുടുംബത്തിൽ ആനന്ദം നിറയ്ക്കും.',
                'ta' => 'அன்பை எளிதில் வெளிக்காட்ட மாட்டீர்கள், ஆனால் ஒருமுறை உறுதிபூண்டால் உங்கள் விசுவாசம் மாறாது. குடும்பக் கடமைகளை சிரமேற்கொண்டு நிறைவேற்றுவீர்கள். பாசத்தை அவ்வப்போது வெளிப்படுத்துவது உறவை பலப்படுத்தும்.',
                'hi' => 'आप अपनी भावनाएं प्रकट करने में समय लेते हैं, परंतु एक बार समर्पित होने पर आपकी निष्ठा अटूट होती है। आप पारिवारिक दायित्वों को पूरी गंभीरता से निभाते हैं। अपने प्रेम को खुलकर व्यक्त करने से दांपत्य अधिक मधुर बनेगा।',
            ],
            'health_prediction' => [
                'en' => 'Shani governs the skeletal structure, joints, teeth, knees, and longevity. Maintain joint mobility through regular yoga stretching, warm sesame oil massages (Abhyanga), and magnesium-rich foods.',
                'ml' => 'ശനി അസ്ഥികൾ, സന്ധികൾ, പല്ലുകൾ, വാതദോഷം എന്നിവയെ ബാധിക്കാം. സന്ധിവേദനകൾ വരാതിരിക്കാൻ നല്ലെണ്ണ കൊണ്ടുള്ള അഭ്യംഗസ്നാനം ഉത്തമമാണ്. നിത്യേനയുള്ള ലഘു വ്യായാമങ്ങൾ വാതദോഷം അകറ്റും.',
                'ta' => 'எலும்புகள், மூட்டுகள், பற்கள் மற்றும் வாதத்தைக் குறிக்கிறது. மூட்டு வலி வராமல் இருக்க நல்லெண்ணெய் தேய்த்துக் குளிப்பதும், உடற்பயிற்சியும் நலம் தரும்.',
                'hi' => 'शनि देव हड्डियों, जोड़ों, घुटनों और वात दोष के नियंत्रक हैं। तिल के तेल से मालिश और नियमित योगाभ्यास जोड़ों को स्वस्थ रखेगा। संतुलित जीवनशैली अपनाएं।',
            ],
            'doctor_remedy' => [
                'en' => 'Light a sesame oil lamp (Ellu Thiri) for Lord Shani on Saturdays. Serve underprivileged elderly persons or provide footwear to laborers to receive Shani Bhagavan’s benevolent protection.',
                'ml' => 'ശനിയാഴ്ചകളിൽ ശാസ്താക്ഷേത്രത്തിലോ ശനീശ്വരനടയിലോ എള്ളുതിരി കൊളുത്തുക. ശനി ഗായത്രി ജപിക്കുക, വയോധികർക്കും പാവപ്പെട്ട തൊഴിലാളികൾക്കും അന്നദാനമോ വസ്ത്രദാനമോ നൽകുന്നത് ശനിദോഷങ്ങൾ ശമിപ്പിക്കും.',
                'ta' => 'சனிக்கிழமைகளில் ஐயப்பன் அல்லது சனீஸ்வர பகவானுக்கு நல்லெண்ணெய் தீபமிட்டு வழிபடவும். ஏழை எளியோர்க்கும், முதியோர்க்கும் உணவும் பாதரட்சையும் (செருப்பு) தானம் செய்வது சனியின் அருளைப் பெற்றுத் தரும்.',
                'hi' => 'शनिवार को शनि मंदिर या पीपल के वृक्ष के नीचे तिल या सरसों के तेल का दीपक जलाएं। असहाय, वृद्धजनों और मजदूरों की सेवा व अन्न-वस्त्र दान करने से शनि देव की असीम कृपा बरसती है।',
            ],
        ],
        9 => [
            'en' => 'Mangal / Kuja (Mars)',
            'ml' => 'ചൊവ്വ / കുജൻ (Mangal)',
            'ta' => 'செவ்வாய் / அங்காரகன் (Chevvai)',
            'hi' => 'मंगल / भौम (Mars)',
            'archetype' => [
                'en' => 'The Dynamic Champion & Resolute Pioneer (യോദ്ധാവ്)',
                'ml' => 'ധീരയോദ്ധാവും കർമ്മനായകനും (The Dynamic Champion)',
                'ta' => 'வீர தளபதி மற்றும் துணிச்சலான முன்னோடி (The Champion)',
                'hi' => 'पराक्रमी योद्धा और निर्भीक पथप्रदर्शक (The Champion)',
            ],
            'deity' => [
                'en' => 'Lord Murugan / Subrahmanya / Lord Hanuman',
                'ml' => 'ശ്രീ മുരുകൻ (സുബ്രഹ്മണ്യൻ) / ശ്രീ ഹനുമാൻ സ്വാമി',
                'ta' => 'ஸ்ரீ முருகப் பெருமான் / ஸ்ரீ அனுமன்',
                'hi' => 'भगवान कार्तिकेय (मुरुगन) / श्री हनुमान जी',
            ],
            'element' => [
                'en' => 'Fire / Raw Courage (ധീരത / തേജസ്സ്)',
                'ml' => 'അഗ്നി / സാഹസികത (ക്ഷാത്രവീര്യം)',
                'ta' => 'நெருப்பு / வீரம் (சத்திரிய தத்துவம்)',
                'hi' => 'अग्नि / अदम्य पराक्रम (अग्नि तत्व)',
            ],
            'traits' => [
                'en' => 'Fearless courage, protective drive, decisive executive action, physical stamina, and pioneering determination.',
                'ml' => 'നിർഭയത്വം, അപാരമായ ഊർജ്ജസ്വലത, വേഗത്തിലുള്ള തീരുമാനങ്ങൾ, ശാരീരികക്ഷമത, ലക്ഷ്യബോധം.',
                'ta' => 'அஞ்சா நெஞ்சம், ஆற்றல், உடனடி முடிவெடுக்கும் திறன், உடல் உறுதி, தலைமை தாங்கும் துணிச்சல்.',
                'hi' => 'निर्भीक साहस, रक्षक स्वभाव, त्वरित निर्णय क्षमता, शारीरिक बल और लक्ष्य के प्रति अडिग निष्ठा।',
            ],
            'gemstone_en' => 'Red Coral (Pavizham)',
            'gemstone_ml' => 'പവിഴം (Natural Mediterranean Red Coral)',
            'gemstone_ta' => 'பவளம் (Red Coral)',
            'gemstone_hi' => 'मूंगा (Red Coral)',
            'wearing_rule' => [
                'en' => 'Wear in Gold or Copper on the Ring Finger on a Tuesday morning within one hour of sunrise.',
                'ml' => 'ചൊവ്വാഴ്ച രാവിലെ സൂര്യോദയത്തിന് ശേഷം സ്വർണ്ണത്തിലോ ചെമ്പിലോ മോതിരവിരലിൽ ധരിക്കുക.',
                'ta' => 'செவ்வாய்க்கிழமை காலையில் தங்கம் அல்லது செம்பில் மோதிர விரலில் அணியவும்.',
                'hi' => 'मंगलवार की सुबह सूर्योदय के 1 घंटे के भीतर सोने या तांबे में अनामिका अंगुली में धारण करें।',
            ],
            'lucky_color' => [
                'en' => 'Coral Red, Crimson, Blood Red, Copper',
                'ml' => 'ചുവപ്പ്, പവിഴച്ചുവപ്പ്, ചെമ്പ് നിറം',
                'ta' => 'பவளச் சிவப்பு, அடர் சிவப்பு, தாமிர நிறம்',
                'hi' => 'मूंगा लाल, गहरा लाल, तांबई रंग',
            ],
            'lucky_day' => [
                'en' => 'Tuesday (ചൊവ്വാഴ്ച)',
                'ml' => 'ചൊവ്വാഴ്ച (Tuesday)',
                'ta' => 'செவ்வாய்க்கிழமை (Tuesday)',
                'hi' => 'मंगलवार (Tuesday)',
            ],
            'lucky_numbers' => '9, 18, 27 (supportive: 1, 3, 5)',
            'favorable_direction' => [
                'en' => 'South (തെക്ക് - Direction of Mangala Deva)',
                'ml' => 'തെക്ക് (South - മംഗളദേവന്റെ ദിശ)',
                'ta' => 'தெற்கு (செவ்வாயின் திசை)',
                'hi' => 'दक्षिण (मंगल देव की दिशा)',
            ],
            'mantra_sanskrit' => 'ॐ क्रां क्रीं क्रौं सः भौमाय नमः ॥',
            'mantra_translit' => 'Om Kraam Kreem Kroum Sah Bhoumaaya Namah',
            'personality_prediction' => [
                'en' => 'Blessed by Mangal, the cosmic general, you possess high vitality, courage, and an indomitable fighting spirit. You are forthright, action-oriented, and passionately stand up for the weak. You prefer direct action over passive contemplation and thrive when tackling challenging obstacles.',
                'ml' => 'ഗ്രഹങ്ങളുടെ സേനാപതിയായ ചൊവ്വയുടെ അനുഗ്രഹമുള്ള താങ്കൾ ചങ്കൂറ്റവും തന്റേടവുമുള്ള വ്യക്തിയാണ്. അനീതി കണ്ടാൽ പ്രതികരിക്കാനും ദുർബലരെ സംരക്ഷിക്കാനും താങ്കൾ മുന്നിലുണ്ടാകും. ചിന്തിച്ച് സമയം കളയാതെ കാര്യങ്ങൾ പെട്ടെന്ന് ചെയ്തുതീർക്കാനാണ് താങ്കൾക്ക് താല്പര്യം. മുൻകോപം നിയന്ത്രിച്ചാൽ വിജയങ്ങൾ എളുപ്പമാകും.',
                'ta' => 'நவக்கிரகங்களின் சேனாதிபதியான செவ்வாயின் அருளால் நீங்கள் அளவற்ற துணிச்சலும் சுறுசுறுப்பும் கொண்டவர். அநீதியைக் கண்டு பொங்குவீர்கள்; எளியவர்களுக்குத் துணை நிற்பீர்கள். எதையும் நேரடியாகச் செய்து முடிப்பதில் வல்லவர். அவசரக் கோபத்தைத் தவிர்த்தால் வெற்றி நிச்சயம்.',
                'hi' => 'ग्रहों के सेनापति मंगल देव की कृपा से आपमें असीम ऊर्जा, पराक्रम और जुझारू प्रवृत्ति है। आप स्पष्टवादी और कर्मठ हैं तथा निर्बलों की रक्षा के लिए सदैव तत्पर रहते हैं। आप केवल योजनाएं बनाने के बजाय तुरंत कार्य करने में विश्वास रखते हैं। क्रोध पर नियंत्रण आपको अपराजेय बनाएगा।',
            ],
            'career_prediction' => [
                'en' => 'Dominates in surgical medicine, armed forces, law enforcement, civil & mechanical engineering, sports, real estate development, manufacturing, and executive crisis management. You are a natural captain of the ship.',
                'ml' => 'സൈന്യം, പോലീസ്, സർജറി (മെഡിക്കൽ), സിവിൽ/മെക്കാനിക്കൽ എൻജിനീയറിംഗ്, കായികരംഗം, റിയൽ എസ്റ്റേറ്റ്, വ്യവസായ നേതൃത്വം എന്നീ മേഖലകളിൽ താങ്കൾ തിളങ്ങും. വെല്ലുവിളികൾ നിറഞ്ഞ സ്ഥാനങ്ങളിൽ താങ്കൾ അസാധാരണ വിജയം നേടും.',
                'ta' => 'ராணுவம், காவல்துறை, அறுவை சிகிச்சை மருத்துவம், பொறியியல், விளையாட்டு, ரியல் எஸ்டேட், தொழிற்சாலைகளில் ஆதிக்கம் செலுத்துவீர்கள். சவாலான பணிகளை முன்னின்று முடிக்கும் தலைமைப் பொறுப்புகள் உங்களுக்குப் பொருந்தும்.',
                'hi' => 'सेना, पुलिस, शल्य चिकित्सा (सर्जरी), मैकेनिकल व सिविल इंजीनियरिंग, खेलकूद, रियल एस्टेट, उद्योग और आपातकालीन प्रबंधन में आप शिखर पर रहेंगे। आप जन्मजात साहसी और कुशल प्रशासक हैं।',
            ],
            'relationship_prediction' => [
                'en' => 'Passionate and ardent in romance. You protect your family with tiger-like vigilance. Channeling fiery impulses and practicing calm patience during minor disputes ensures lasting domestic joy.',
                'ml' => 'കുടുംബത്തോടും പങ്കാളിയോടും അതിയായ സ്നേഹവും സംരക്ഷണഭാവവും പുലർത്തുന്ന വ്യക്തിയാണ് താങ്കൾ. ചെറിയ അഭിപ്രായവ്യത്യാസങ്ങളിൽ മുൻകോപം കാട്ടാതെ സംയമനം പാലിക്കുന്നത് കുടുംബത്തിൽ സദാ സമാധാനവും സ്നേഹവും നിറയ്ക്കും.',
                'ta' => 'குடும்பத்தின் மீது அதீத பாசமும், பாதுகாக்கும் உணர்வும் கொண்டவர். சிறு வாக்குவாதங்களின் போது கோபப்படாமல் அமைதி காத்தால் இல்லறம் என்றும் இன்பமயமாக இருக்கும்.',
                'hi' => 'आप अपने परिवार और जीवनसाथी के प्रति अत्यंत निष्ठावान और सुरक्षात्मक हैं। कभी-कभार होने वाले मतभेदों में धैर्य और संयम बरतने से आपके दांपत्य में सदैव मधुरता और शांति बनी रहेगी।',
            ],
            'health_prediction' => [
                'en' => 'Mars rules red blood cells, muscular strength, bone marrow, and internal heat. Stay hydrated, engage in regular vigorous physical exercise, and balance internal heat with cooling coconut water and pomegranates.',
                'ml' => 'ചൊവ്വ രക്തം, പേശികൾ, ശരീരത്തിലെ ചൂട് എന്നിവയെ നിയന്ത്രിക്കുന്നു. ധാരാളം ശുദ്ധജലം, ഇളനീർ എന്നിവ കുടിക്കുക. നിത്യേനയുള്ള വ്യായാമം ശരീരത്തിലെ അധിക ഊർജ്ജത്തെയും കോപത്തെയും സന്തുലിതമാക്കും.',
                'ta' => 'செவ்வாய் ரத்தம், தசை பலம் மற்றும் உடலின் உஷ்ணத்தைக் குறிக்கிறது. உடற்பயிற்சி செய்வதும், இளநீர் மற்றும் மாதுளை உண்பதும் உடலின் உஷ்ணத்தைத் தணித்து ஆரோக்கியம் தரும்.',
                'hi' => 'मंगल देव रक्त, मांसपेशियों की शक्ति और शरीर की ऊष्मा के कारक हैं। पर्याप्त जल, नारियल पानी का सेवन और नियमित कसरत आपके शरीर को बलिष्ठ और स्वस्थ रखेगी।',
            ],
            'doctor_remedy' => [
                'en' => 'Chant the Hanuman Chalisa or Subrahmanya Ashtakam on Tuesdays. Donate blood or provide nutritious meals to the needy to transform Mars energy into divine courage.',
                'ml' => 'ചൊവ്വാഴ്ചകളിൽ സുബ്രഹ്മണ്യ ഭജനമോ ഹനുമാൻ ചാലിസയോ ജപിക്കുക. ക്ഷേത്രത്തിൽ ചുവന്ന പുഷ്പങ്ങൾ അർപ്പിക്കുക, രക്തദാനം ചെയ്യുകയോ സാധുക്കൾക്ക് അന്നദാനം നൽകുകയോ ചെയ്യുന്നത് ചൊവ്വാദോഷങ്ങളെ സൗഭാഗ്യങ്ങളാക്കി മാറ്റും.',
                'ta' => 'செவ்வாய்க்கிழமைகளில் கந்த சஷ்டி கவசம் அல்லது அனுமன் சாலிசா பாராயணம் செய்யவும். ரத்த தானம் செய்வதும், ஏழைகளுக்கு உணவளிப்பதும் செவ்வாயின் தோஷங்களை நீக்கி நல்வாழ்வு தரும்.',
                'hi' => 'मंगलवार को हनुमान चालीसा या कार्तिकेय स्तोत्र का पाठ करें। रक्तदान करना या जरूरतमंदों को भोजन कराना मंगल की ऊर्जा को सकारात्मक और कल्याणकारी बनाता है।',
            ],
        ],
    ];

    public static function reduceToSingleDigit(int $number): int
    {
        while ($number > 9) {
            $sum = 0;
            $digits = str_split((string)$number);
            foreach ($digits as $d) {
                $sum += (int)$d;
            }
            $number = $sum;
        }
        return $number === 0 ? 9 : $number;
    }

    public static array $nakshatras = [
        1 => ['name_en' => 'Ashwini', 'name_ml' => 'അശ്വതി (Ashwati)', 'lord' => 'Ketu (കേതു)', 'deity' => 'Ashwini Kumaras', 'symbol' => 'Horse Head (കുതിരത്തല)'],
        2 => ['name_en' => 'Bharani', 'name_ml' => 'ഭരണി (Bharani)', 'lord' => 'Venus (ശുക്രൻ)', 'deity' => 'Yama Dharma', 'symbol' => 'Yoni / Womb (അടുപ്പ്)'],
        3 => ['name_en' => 'Krittika', 'name_ml' => 'കാർത്തിക (Karthika)', 'lord' => 'Sun (സൂര്യൻ)', 'deity' => 'Agni Deva', 'symbol' => 'Flame / Razor (വാൾ/കത്തി)'],
        4 => ['name_en' => 'Rohini', 'name_ml' => 'രോഹിണി (Rohini)', 'lord' => 'Moon (ചന്ദ്രൻ)', 'deity' => 'Brahma / Prajapati', 'symbol' => 'Chariot / Cart (രഥം)'],
        5 => ['name_en' => 'Mrigashirsha', 'name_ml' => 'മകയിരം (Makayiram)', 'lord' => 'Mars (ചൊവ്വ)', 'deity' => 'Soma Deva', 'symbol' => 'Deer Head (മാൻതല)'],
        6 => ['name_en' => 'Ardra', 'name_ml' => 'തിരുവാതിര (Thiruvathira)', 'lord' => 'Rahu (രാഹു)', 'deity' => 'Rudra (ശിവൻ)', 'symbol' => 'Teardrop / Jewel (രത്നം/കണ്ണീർത്തുള്ളി)'],
        7 => ['name_en' => 'Punarvasu', 'name_ml' => 'പുണർതം (Punartham)', 'lord' => 'Jupiter (വ്യാഴം)', 'deity' => 'Aditi', 'symbol' => 'Bow and Quiver (വില്ലും ആവനാഴിയും)'],
        8 => ['name_en' => 'Pushya', 'name_ml' => 'പൂയം (Pooyam)', 'lord' => 'Saturn (ശനി)', 'deity' => 'Brihaspati', 'symbol' => 'Lotus / Udder (താമര/അമ്പിളി)'],
        9 => ['name_en' => 'Ashlesha', 'name_ml' => 'ആയില്യം (Ayilyam)', 'lord' => 'Mercury (ബുധൻ)', 'deity' => 'Sarpas / Nagas', 'symbol' => 'Coiled Serpent (പാമ്പ്)'],
        10 => ['name_en' => 'Magha', 'name_ml' => 'മകം (Makam)', 'lord' => 'Ketu (കേതു)', 'deity' => 'Pitris (പിതൃക്കൾ)', 'symbol' => 'Royal Palanquin / Throne (സിംഹാസനം)'],
        11 => ['name_en' => 'Purva Phalguni', 'name_ml' => 'പൂരം (Pooram)', 'lord' => 'Venus (ശുക്രൻ)', 'deity' => 'Bhaga', 'symbol' => 'Front Legs of Couch (കട്ടിലിന്റെ മുൻകാലുകൾ)'],
        12 => ['name_en' => 'Uttara Phalguni', 'name_ml' => 'ഉത്രം (Uthram)', 'lord' => 'Sun (സൂര്യൻ)', 'deity' => 'Aryaman', 'symbol' => 'Back Legs of Couch (കട്ടിലിന്റെ പിൻകാലുകൾ)'],
        13 => ['name_en' => 'Hasta', 'name_ml' => 'അത്തം (Atham)', 'lord' => 'Moon (ചന്ദ്രൻ)', 'deity' => 'Savitar (സൂര്യൻ)', 'symbol' => 'Open Palm (കൈപ്പത്തി)'],
        14 => ['name_en' => 'Chitra', 'name_ml' => 'ചിത്തിര (Chithira)', 'lord' => 'Mars (ചൊവ്വ)', 'deity' => 'Twashtar / Vishwakarma', 'symbol' => 'Shining Pearl / Gem (മുത്ത്)'],
        15 => ['name_en' => 'Swati', 'name_ml' => 'ചോതി (Chothi)', 'lord' => 'Rahu (രാഹു)', 'deity' => 'Vayu Deva (വായു)', 'symbol' => 'Young Coral / Shoot (വിളക്ക്/നാമ്പ്)'],
        16 => ['name_en' => 'Vishakha', 'name_ml' => 'വിശാഖം (Vishakham)', 'lord' => 'Jupiter (വ്യാഴം)', 'deity' => 'Indragni', 'symbol' => 'Triumphal Arch (തോരണം/വില്ല്)'],
        17 => ['name_en' => 'Anuradha', 'name_ml' => 'അനിഴം (Anizham)', 'lord' => 'Saturn (ശനി)', 'deity' => 'Mitra Deva', 'symbol' => 'Triumphal Lotus (താമര)'],
        18 => ['name_en' => 'Jyeshtha', 'name_ml' => 'തൃക്കേട്ട (Thrikketta)', 'lord' => 'Mercury (ബുധൻ)', 'deity' => 'Indra Dev', 'symbol' => 'Circular Talisman / Umbrella (കുട/കുണ്ഡലം)'],
        19 => ['name_en' => 'Mula', 'name_ml' => 'മൂലം (Moolam)', 'lord' => 'Ketu (കേതു)', 'deity' => 'Nirriti', 'symbol' => 'Bunch of Tied Roots (വേരുകൾ)'],
        20 => ['name_en' => 'Purva Ashadha', 'name_ml' => 'പൂരാടം (Pooradam)', 'lord' => 'Venus (ശുക്രൻ)', 'deity' => 'Apas (ജലദേവത)', 'symbol' => 'Winnowing Basket (മുറം)'],
        21 => ['name_en' => 'Uttara Ashadha', 'name_ml' => 'ഉത്രാടം (Uthradam)', 'lord' => 'Sun (സൂര്യൻ)', 'deity' => 'Vishwadevas', 'symbol' => 'Elephant Tusk (ആനക്കൊമ്പ്)'],
        22 => ['name_en' => 'Shravana', 'name_ml' => 'തിരുവോണം (Thiruvonam)', 'lord' => 'Moon (ചന്ദ്രൻ)', 'deity' => 'Maha Vishnu', 'symbol' => 'Three Footprints / Ear (തൃപ്പാദം/ചെവി)'],
        23 => ['name_en' => 'Dhanishta', 'name_ml' => 'അവിട്ടം (Avittam)', 'lord' => 'Mars (ചൊവ്വ)', 'deity' => 'Ashta Vasus', 'symbol' => 'Mridangam / Flute (മദ്ദളം/മുരളി)'],
        24 => ['name_en' => 'Shatabhisha', 'name_ml' => 'ചതയം (Chathayam)', 'lord' => 'Rahu (രാഹു)', 'deity' => 'Varuna Deva', 'symbol' => 'Empty Circle / 100 Physicians (വൃത്തം)'],
        25 => ['name_en' => 'Purva Bhadrapada', 'name_ml' => 'പൂരൂരുട്ടാതി (Poororuttathi)', 'lord' => 'Jupiter (വ്യാഴം)', 'deity' => 'Aja Ekapada', 'symbol' => 'Two Front Legs of Cot (വാൾ)'],
        26 => ['name_en' => 'Uttara Bhadrapada', 'name_ml' => 'ഉത്രട്ടാതി (Uthrattathi)', 'lord' => 'Saturn (ശനി)', 'deity' => 'Ahirbudhnya', 'symbol' => 'Twins / Snake in Sea (പാമ്പ്)'],
        27 => ['name_en' => 'Revati', 'name_ml' => 'രേവതി (Revathi)', 'lord' => 'Mercury (ബുധൻ)', 'deity' => 'Pushan', 'symbol' => 'Fish Pair / Ship (മത്സ്യം/തോണി)'],
    ];

    public static array $zodiacSigns = [
        1 => ['index' => 1, 'key' => 'medam', 'name_ml' => 'മേടം (Medam)', 'name_en' => 'Aries (Medam)', 'ruler' => 'Mars (ചൊവ്വ)', 'lord' => 'Mars (ചൊവ്വ)', 'element' => 'Fire (അഗ്നി)', 'symbol' => '♈'],
        2 => ['index' => 2, 'key' => 'edavam', 'name_ml' => 'ഇടവം (Edavam)', 'name_en' => 'Taurus (Edavam)', 'ruler' => 'Venus (ശുക്രൻ)', 'lord' => 'Venus (ശുക്രൻ)', 'element' => 'Earth (ഭൂമി)', 'symbol' => '♉'],
        3 => ['index' => 3, 'key' => 'mithunam', 'name_ml' => 'മിഥുനം (Mithunam)', 'name_en' => 'Gemini (Mithunam)', 'ruler' => 'Mercury (ബുധൻ)', 'lord' => 'Mercury (ബുധൻ)', 'element' => 'Air (വായു)', 'symbol' => '♊'],
        4 => ['index' => 4, 'key' => 'karkidakam', 'name_ml' => 'കർക്കിടകം (Karkidakam)', 'name_en' => 'Cancer (Karkidakam)', 'ruler' => 'Moon (ചന്ദ്രൻ)', 'lord' => 'Moon (ചന്ദ്രൻ)', 'element' => 'Water (ജലം)', 'symbol' => '♋'],
        5 => ['index' => 5, 'key' => 'chingam', 'name_ml' => 'ചിങ്ങം (Chingam)', 'name_en' => 'Leo (Chingam)', 'ruler' => 'Sun (സൂര്യൻ)', 'lord' => 'Sun (സൂര്യൻ)', 'element' => 'Fire (അഗ്നി)', 'symbol' => '♌'],
        6 => ['index' => 6, 'key' => 'kanni', 'name_ml' => 'കന്നി (Kanni)', 'name_en' => 'Virgo (Kanni)', 'ruler' => 'Mercury (ബുധൻ)', 'lord' => 'Mercury (ബുധൻ)', 'element' => 'Earth (ഭൂമി)', 'symbol' => '♍'],
        7 => ['index' => 7, 'key' => 'thulam', 'name_ml' => 'തുലാം (Thulam)', 'name_en' => 'Libra (Thulam)', 'ruler' => 'Venus (ശുക്രൻ)', 'lord' => 'Venus (ശുക്രൻ)', 'element' => 'Air (വായു)', 'symbol' => '♎'],
        8 => ['index' => 8, 'key' => 'vrischikam', 'name_ml' => 'വൃശ്ചികം (Vrischikam)', 'name_en' => 'Scorpio (Vrischikam)', 'ruler' => 'Mars (ചൊവ്വ)', 'lord' => 'Mars (ചൊവ്വ)', 'element' => 'Water (ജലം)', 'symbol' => '♏'],
        9 => ['index' => 9, 'key' => 'dhanu', 'name_ml' => 'ധനു (Dhanu)', 'name_en' => 'Sagittarius (Dhanu)', 'ruler' => 'Jupiter (വ്യാഴം)', 'lord' => 'Jupiter (വ്യാഴം)', 'element' => 'Fire (അഗ്നി)', 'symbol' => '♐'],
        10 => ['index' => 10, 'key' => 'makaram', 'name_ml' => 'മകരം (Makaram)', 'name_en' => 'Capricorn (Makaram)', 'ruler' => 'Saturn (ശനി)', 'lord' => 'Saturn (ശനി)', 'element' => 'Earth (ഭൂമി)', 'symbol' => '♑'],
        11 => ['index' => 11, 'key' => 'kumbham', 'name_ml' => 'കുംഭം (Kumbham)', 'name_en' => 'Aquarius (Kumbham)', 'ruler' => 'Saturn (ശനി)', 'lord' => 'Saturn (ശനി)', 'element' => 'Air (വായു)', 'symbol' => '♒'],
        12 => ['index' => 12, 'key' => 'meenam', 'name_ml' => 'മീനം (Meenam)', 'name_en' => 'Pisces (Meenam)', 'ruler' => 'Jupiter (വ്യാഴം)', 'lord' => 'Jupiter (വ്യാഴം)', 'element' => 'Water (ജലം)', 'symbol' => '♓'],
    ];

    public static function calculateLagna(?string $birthTimeStr, array $solarSign): array
    {
        $signMap = [
            'Medam' => 1, 'Edavam' => 2, 'Mithunam' => 3, 'Karkidakam' => 4,
            'Chingam' => 5, 'Kanni' => 6, 'Thulam' => 7, 'Vrischikam' => 8,
            'Dhanu' => 9, 'Makaram' => 10, 'Kumbham' => 11, 'Meenam' => 12,
        ];
        $baseIdx = 1;
        foreach ($signMap as $k => $idx) {
            if (str_contains($solarSign['name_en'] ?? '', $k) || str_contains($solarSign['name_ml'] ?? '', $k)) {
                $baseIdx = $idx;
                break;
            }
        }

        if (empty($birthTimeStr)) {
            $lagnaSign = self::$zodiacSigns[$baseIdx];
            $lagnaSign['is_estimated'] = true;
            $lagnaSign['time_label'] = 'Sunrise Default (സൂര്യോദയ ലഗ്നം)';
            $lagnaSign['hora'] = '06:00 AM';
            return $lagnaSign;
        }

        try {
            $timeCarbon = Carbon::parse($birthTimeStr);
            $totalMinutes = ($timeCarbon->hour * 60) + $timeCarbon->minute;
            $diffMinutes = ($totalMinutes - 360 + 1440) % 1440;
            $lagnaOffset = (int) floor($diffMinutes / 120);
            $lagnaIdx = (($baseIdx - 1 + $lagnaOffset) % 12) + 1;
            $lagnaSign = self::$zodiacSigns[$lagnaIdx];
            $lagnaSign['is_estimated'] = false;
            $lagnaSign['time_label'] = 'Calculated from Birth Time';
            $lagnaSign['hora'] = $timeCarbon->format('h:i A');
            return $lagnaSign;
        } catch (\Throwable $e) {
            $lagnaSign = self::$zodiacSigns[$baseIdx];
            $lagnaSign['is_estimated'] = true;
            $lagnaSign['time_label'] = 'Standard Sunrise';
            $lagnaSign['hora'] = '06:00 AM';
            return $lagnaSign;
        }
    }

    public static function calculateNakshatra(Carbon $carbon, ?string $birthTimeStr = null): array
    {
        $dayOfYear = $carbon->dayOfYear;
        $yearOffset = ($carbon->year * 11) % 27;
        $timeOffset = 0;
        if (!empty($birthTimeStr)) {
            try {
                $timeCarbon = Carbon::parse($birthTimeStr);
                $timeOffset = (int) floor($timeCarbon->hour / 12);
            } catch (\Throwable $e) {
                $timeOffset = 0;
            }
        }
        $nakshatraIndex = (($dayOfYear + $yearOffset + $timeOffset) % 27) + 1;
        $n = self::$nakshatras[$nakshatraIndex] ?? self::$nakshatras[1];
        $n['index'] = $nakshatraIndex;
        return $n;
    }

    public static function calculate12Bhavas(array $lagna, Carbon $carbon): array
    {
        $bhavaNames = [
            1 => ['name_ml' => 'ഒന്നാം ഭാവം (തനു ഭാവം)', 'name_en' => '1st House (Tanu Bhava)', 'theme' => 'Life Path, Vitality & Physical Persona', 'focus' => 'ആയുസ്സ്, ശരീരഘടന, വ്യക്തിത്വം'],
            2 => ['name_ml' => 'രണ്ടാം ഭാവം (ധന ഭാവം)', 'name_en' => '2nd House (Dhana Bhava)', 'theme' => 'Wealth, Speech & Family Treasures', 'focus' => 'ധനസമ്പാദനം, വാക്ചാതുര്യം, കുടുംബം'],
            3 => ['name_ml' => 'മൂന്നാം ഭാവം (സഹജ ഭാവം)', 'name_en' => '3rd House (Sahaja Bhava)', 'theme' => 'Courage, Enterprise & Siblings', 'focus' => 'ധൈര്യം, സഹോദരങ്ങൾ, പരിശ്രമശക്തി'],
            4 => ['name_ml' => 'നാലാം ഭാവം (സുഖ ഭാവം)', 'name_en' => '4th House (Sukha Bhava)', 'theme' => 'Mother, Real Estate, Vehicles & Happiness', 'focus' => 'മാതൃസൗഖ്യം, ഗൃഹം, വാഹനം, മനസ്സമാധാനം'],
            5 => ['name_ml' => 'അഞ്ചാം ഭാവം (പുത്ര ഭാവം)', 'name_en' => '5th House (Putra Bhava)', 'theme' => 'Intellect, Creative Genius & Purva Punya', 'focus' => 'വിദ്യാഭ്യാസം, സന്താനഭാഗ്യം, പൂർവ്വപുണ്യം'],
            6 => ['name_ml' => 'ആറാം ഭാവം (ശത്രു-രോഗ ഭാവം)', 'name_en' => '6th House (Ari Bhava)', 'theme' => 'Competitive Edge, Daily Work & Health Defense', 'focus' => 'ശത്രുജയം, കർമ്മരംഗം, രോഗപ്രതിരോധം'],
            7 => ['name_ml' => 'ഏഴാം ഭാവം (കളത്ര ഭാവം)', 'name_en' => '7th House (Kalatra Bhava)', 'theme' => 'Marriage, Partnership & Public Relations', 'focus' => 'ദാമ്പത്യം, ബിസിനസ്സ് കൂട്ടുകെട്ടുകൾ, വിദേശബന്ധങ്ങൾ'],
            8 => ['name_ml' => 'എട്ടാം ഭാവം (ആയുർ ഭാവം)', 'name_en' => '8th House (Ayur Bhava)', 'theme' => 'Longevity, Secret Wisdom & Major Transformation', 'focus' => 'ദീർഘായുസ്സ്, നിഗൂഢവിദ്യകൾ, അപ്രതീക്ഷിത ഭാഗ്യങ്ങൾ'],
            9 => ['name_ml' => 'ഒൻപതാം ഭാവം (ഭാഗ്യ ഭാവം)', 'name_en' => '9th House (Bhagya Bhava)', 'theme' => 'Divine Grace, Guru, Higher Truth & Pilgrimages', 'focus' => 'ഈശ്വരാനുഗ്രഹം, ഭാഗ്യം, പിതാവ്, ധർമ്മനിഷ്ഠ'],
            10 => ['name_ml' => 'പത്താം ഭാവം (കർമ്മ ഭാവം)', 'name_en' => '10th House (Karma Bhava)', 'theme' => 'Career Zenith, Authority, Prestige & Social Standing', 'focus' => 'ഉദ്യോഗം, കീർത്തി, അധികാരം, നേതൃപദവി'],
            11 => ['name_ml' => 'പതിനൊന്നാം ഭാവം (ലാഭ ഭാവം)', 'name_en' => '11th House (Labha Bhava)', 'theme' => 'Unstoppable Gains, Network Wealth & Aspirations', 'focus' => 'സർവ്വകാര്യസിദ്ധി, വൻലാഭം, സുഹൃത്തുക്കൾ'],
            12 => ['name_ml' => 'പന്ത്രണ്ടാം ഭാവം (മോക്ഷ ഭാവം)', 'name_en' => '12th House (Vyaya Bhava)', 'theme' => 'Foreign Settling, Generosity & Moksha (Liberation)', 'focus' => 'വിദേശവാസം, മോക്ഷം, സൽക്കർമ്മങ്ങൾക്കുള്ള ചെലവ്'],
        ];

        $lagnaIndex = $lagna['index'] ?? 1;
        $bhavas = [];

        for ($h = 1; $h <= 12; $h++) {
            $signIdx = (($lagnaIndex - 1 + ($h - 1)) % 12) + 1;
            $sign = self::$zodiacSigns[$signIdx];
            $bhavas[$h] = [
                'house' => $h,
                'name_ml' => $bhavaNames[$h]['name_ml'],
                'name_en' => $bhavaNames[$h]['name_en'],
                'theme' => $bhavaNames[$h]['theme'],
                'focus' => $bhavaNames[$h]['focus'],
                'ruling_sign_ml' => $sign['name_ml'],
                'ruling_sign_en' => $sign['name_en'],
                'ruler' => $sign['ruler'],
                'symbol' => $sign['symbol'],
                'element' => $sign['element'],
            ];
        }

        return $bhavas;
    }

    public function calculate(
        string $birthDateStr,
        ?string $name = null,
        ?string $service = null,
        ?string $birthTime = null,
        ?string $birthPlace = null
    ): array {
        $carbon = Carbon::parse($birthDateStr);
        $day = $carbon->day;
        $month = $carbon->month;
        $year = $carbon->year;

        // 1. Birth Number (Mulank) = Day reduced
        $mulank = self::reduceToSingleDigit($day);

        // 2. Destiny Number (Bhagyank) = Full DOB digits reduced
        $fullDigits = str_split(sprintf('%02d%02d%04d', $day, $month, $year));
        $destinySum = array_sum(array_map('intval', $fullDigits));
        $bhagyank = self::reduceToSingleDigit($destinySum);

        // 3. Ruling Planet based on Mulank
        $planet = self::$planets[$mulank] ?? self::$planets[1];

        // 4. Secondary Influencing Planet based on Bhagyank
        $destinyPlanet = self::$planets[$bhagyank] ?? self::$planets[1];

        // 5. Malayalam Surya Rasi
        $solarSign = self::getMalayalamSolarSign($carbon);

        // 6. Deep Vedic Kundali & Lagna Calculations (Tiers 2 & 3)
        $lagna = self::calculateLagna($birthTime, $solarSign);
        $nakshatra = self::calculateNakshatra($carbon, $birthTime);
        $bhavas = self::calculate12Bhavas($lagna, $carbon);

        // 7. Personal Year Forecast Number (Varshaphala)
        $currentYear = (int) date('Y');
        $personalYear = self::reduceToSingleDigit($day + $month + $currentYear);

        // 8. Pre-filled WhatsApp message & Indian formatted dates
        $clientName = trim($name ?: 'Seeker');
        $chosenService = trim($service ?: 'Accurate Predictions & Jathakam');
        $formattedDate = $carbon->format('d-m-Y'); // Indian DD-MM-YYYY format
        $displayDate = $carbon->format('d-M-Y');
        $cleanedBirthTime = trim($birthTime ?? '');
        $cleanedBirthPlace = trim($birthPlace ?? '');

        $whatsappText = "Namaskaram DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology),\n\n"
            . "I checked my Vedic Reading on Covilakam Astrology:\n"
            . "• Name: {$clientName}\n"
            . "• Date of Birth: {$formattedDate}\n"
            . ($cleanedBirthTime ? "• Time of Birth: {$cleanedBirthTime}\n" : "")
            . ($cleanedBirthPlace ? "• Place of Birth: {$cleanedBirthPlace}\n" : "")
            . "• Birth Number (Mulank): {$mulank} [{$planet['en']} / {$planet['ml']}]\n"
            . "• Destiny Number (Bhagyank): {$bhagyank} [{$destinyPlanet['en']}]\n"
            . "• Solar Sign (Surya Rasi): {$solarSign['name_ml']} ({$solarSign['name_en']})\n"
            . "• Ascendant (Lagna): {$lagna['name_ml']} ({$lagna['name_en']})\n"
            . "• Janma Nakshatra: {$nakshatra['name_ml']} (Lord: {$nakshatra['lord']})\n"
            . "• Recommended Gemstone: {$planet['gemstone_en']} ({$planet['gemstone_ml']})\n"
            . "• Plan Chosen: {$chosenService}\n\n"
            . "I would like to consult with you.";

        $whatsappUrl = 'https://wa.me/917907052160?text=' . rawurlencode($whatsappText);

        return [
            'name' => $clientName,
            'birth_date' => $formattedDate, // Indian format: 05-01-1978
            'birth_date_display' => $displayDate, // 05-Jan-1978
            'birth_date_raw' => $carbon->format('Y-m-d'),
            'birth_time' => $cleanedBirthTime ?: null,
            'birth_place' => $cleanedBirthPlace ?: null,
            'has_birth_time' => !empty($cleanedBirthTime),
            'has_birth_place' => !empty($cleanedBirthPlace),
            'service_requested' => $chosenService,
            'mulank' => $mulank,
            'bhagyank' => $bhagyank,
            'personal_year' => $personalYear,
            'ruling_planet' => $planet,
            'destiny_planet' => $destinyPlanet,
            'solar_sign' => $solarSign,
            'lagna' => $lagna,
            'nakshatra' => $nakshatra,
            'bhavas' => $bhavas,
            'gemstone_en' => $planet['gemstone_en'],
            'gemstone_ml' => $planet['gemstone_ml'],
            'gemstone_ta' => $planet['gemstone_ta'] ?? $planet['gemstone_en'],
            'gemstone_hi' => $planet['gemstone_hi'] ?? $planet['gemstone_en'],
            'wearing_rule' => $planet['wearing_rule'],
            'lucky_color' => $planet['lucky_color'],
            'lucky_day' => $planet['lucky_day'],
            'lucky_numbers' => $planet['lucky_numbers'],
            'favorable_direction' => $planet['favorable_direction'],
            'mantra_sanskrit' => $planet['mantra_sanskrit'],
            'mantra_translit' => $planet['mantra_translit'],
            'traits' => $planet['traits'],
            'archetype' => $planet['archetype'],
            'personality_prediction' => $planet['personality_prediction'],
            'career_prediction' => $planet['career_prediction'],
            'relationship_prediction' => $planet['relationship_prediction'],
            'health_prediction' => $planet['health_prediction'],
            'doctor_remedy' => $planet['doctor_remedy'],
            'whatsapp_url' => $whatsappUrl,
            'plans' => [
                'free' => [
                    'price' => 0,
                    'title' => 'Vedic Life Essence (Free Instant Preview)',
                    'is_current' => true,
                ],
                'profile_pdf' => [
                    'price' => 100,
                    'slug' => 'vedic-dob-profile-pdf-report',
                    'title' => 'Comprehensive Vedic DOB Profile (Downloadable PDF)',
                    'button_text' => 'Download Full Report (₹100)',
                ],
                'deluxe_kundali' => [
                    'price' => 500,
                    'slug' => 'deluxe-vedic-jathakam-pdf-report',
                    'title' => 'Complete Deluxe Kundali & Deep Jathakam (PDF)',
                    'button_text' => 'Unlock Deluxe Kundali (₹500)',
                ],
            ],
        ];
    }

    public static function getMalayalamSolarSign(Carbon $date): array
    {
        $m = $date->month;
        $d = $date->day;

        if (($m == 4 && $d >= 14) || ($m == 5 && $d <= 14)) {
            return [
                'name_ml' => 'മേടം (Medam)',
                'name_en' => 'Aries (Medam)',
                'name_ta' => 'மேஷம் (Mesham)',
                'name_hi' => 'मेष (Mesha)',
                'symbol' => '♈ Ram',
                'element' => [
                    'en' => 'Fire (അഗ്നി)',
                    'ml' => 'അഗ്നി (Fire)',
                    'ta' => 'நெருப்பு (Fire)',
                    'hi' => 'अग्नि (Fire)',
                ],
                'sanskrit' => 'Mesha',
                'sign_overview' => [
                    'en' => 'Governed by Mars, Medam solar natives possess pioneering zeal, initiative, and courage to initiate new ventures.',
                    'ml' => 'ചൊവ്വയുടെ ആധിപത്യമുള്ള മേടം രാശിക്കാർ നേതൃത്വഗുണവും നിർഭയത്വവും പുതിയ സംരംഭങ്ങൾക്ക് തുടക്കമിടാനുള്ള ധീരതയും ഉള്ളവരാണ്.',
                    'ta' => 'செவ்வாய் பகவானின் ஆட்சி பெற்ற மேஷ ராசிக்காரர்கள் முன்னோடித் தன்மையும், வேகமும், எதையும் சாதிக்கும் துணிச்சலும் கொண்டவர்கள்.',
                    'hi' => 'मंगल के स्वामित्व वाली मेष राशि के जातक ऊर्जावान, साहसी और नए कार्यों की शुरुआत करने में निपुण होते हैं।',
                ],
            ];
        } elseif (($m == 5 && $d >= 15) || ($m == 6 && $d <= 14)) {
            return [
                'name_ml' => 'ഇടവം (Edavam)',
                'name_en' => 'Taurus (Edavam)',
                'name_ta' => 'ரிஷபம் (Rishabham)',
                'name_hi' => 'वृषभ (Vrishabha)',
                'symbol' => '♉ Bull',
                'element' => [
                    'en' => 'Earth (ഭൂമി)',
                    'ml' => 'ഭൂമി (Earth)',
                    'ta' => 'பூமி (Earth)',
                    'hi' => 'पृथ्वी (Earth)',
                ],
                'sanskrit' => 'Vrishabha',
                'sign_overview' => [
                    'en' => 'Governed by Venus, Edavam solar natives are steadfast, reliable, fond of worldly comforts, and master builders of assets.',
                    'ml' => 'ശുക്രന്റെ ആധിപത്യമുള്ള ഇടവം രാശിക്കാർ സ്ഥിരതയുള്ളവരും ആഡംബരപ്രിയരും വിശ്വസ്തരും സമ്പത്ത് സ്വരൂപിക്കുന്നതിൽ സമർത്ഥരുമാണ്.',
                    'ta' => 'சுக்கிரனின் ஆதிக்கம் பெற்ற ரிஷப ராசிக்காரர்கள் நிதானமானவர்கள், சுகபோகங்களை விரும்புபவர்கள் மற்றும் சொத்துக்களைக் குவிக்கும் ஆற்றல் படைத்தவர்கள்.',
                    'hi' => 'शुक्र शासित वृषभ राशि के जातक दृढ़निश्चयी, व्यावहारिक और धन-संपत्ति संचय करने में अत्यंत कुशल होते हैं।',
                ],
            ];
        } elseif (($m == 6 && $d >= 15) || ($m == 7 && $d <= 15)) {
            return [
                'name_ml' => 'മിഥുനം (Mithunam)',
                'name_en' => 'Gemini (Mithunam)',
                'name_ta' => 'மிதுனம் (Mithunam)',
                'name_hi' => 'मिथुन (Mithuna)',
                'symbol' => '♊ Twins',
                'element' => [
                    'en' => 'Air (വായു)',
                    'ml' => 'വായു (Air)',
                    'ta' => 'காற்று (Air)',
                    'hi' => 'वायु (Air)',
                ],
                'sanskrit' => 'Mithuna',
                'sign_overview' => [
                    'en' => 'Governed by Mercury, Mithunam solar natives are intellectual, eloquent communicators, witty, and versatile learners.',
                    'ml' => 'ബുധന്റെ ആധിപത്യമുള്ള മിഥുനം രാശിക്കാർ അറിവ് സമ്പാദിക്കുന്നതിലും ആശയവിനിമയത്തിലും സാമർത്ഥ്യം പുലർത്തുന്നവരാണ്.',
                    'ta' => 'புதனின் ஆதிக்கம் பெற்ற மிதுன ராசிக்காரர்கள் புத்தி கூர்மையும், சிறந்த சொல்வன்மையும், பன்முகத் திறமையும் கொண்டவர்கள்.',
                    'hi' => 'बुध शासित मिथुन राशि के जातक अत्यंत बुद्धिमान, वाकपटु, जिज्ञासु और बहुमुखी प्रतिभा के धनी होते हैं।',
                ],
            ];
        } elseif (($m == 7 && $d >= 16) || ($m == 8 && $d <= 16)) {
            return [
                'name_ml' => 'കർക്കിടകം (Karkidakam)',
                'name_en' => 'Cancer (Karkidakam)',
                'name_ta' => 'கடகம் (Katakam)',
                'name_hi' => 'कर्क (Karka)',
                'symbol' => '♋ Crab',
                'element' => [
                    'en' => 'Water (ജലം)',
                    'ml' => 'ജലം (Water)',
                    'ta' => 'நீர் (Water)',
                    'hi' => 'जल (Water)',
                ],
                'sanskrit' => 'Karkataka',
                'sign_overview' => [
                    'en' => 'Governed by Moon, Karkidakam solar natives are nurturing, deeply intuitive, home-loving, and emotionally protective.',
                    'ml' => 'ചന്ദ്രന്റെ ആധിപത്യമുള്ള കർക്കിടകം രാശിക്കാർ കുടുംബസ്നേഹികളും ആർദ്രഹൃദയരും അന്തർജ്ഞാനമുള്ളവരുമാണ്.',
                    'ta' => 'சந்திரனின் ஆட்சி பெற்ற கடக ராசிக்காரர்கள் பாசமும், ஆழமான உள்ளுணர்வும், குடும்பப் பற்றும் மிகுந்தவர்கள்.',
                    'hi' => 'चंद्र शासित कर्क राशि के जातक संवेदनशील, स्नेही, सहृदय और परिवार के प्रति पूर्ण समर्पित होते हैं।',
                ],
            ];
        } elseif (($m == 8 && $d >= 17) || ($m == 9 && $d <= 16)) {
            return [
                'name_ml' => 'ചിങ്ങം (Chingam)',
                'name_en' => 'Leo (Chingam)',
                'name_ta' => 'சிம்மம் (Simham)',
                'name_hi' => 'सिंह (Simha)',
                'symbol' => '♌ Lion',
                'element' => [
                    'en' => 'Fire (അഗ്നി)',
                    'ml' => 'അഗ്നി (Fire)',
                    'ta' => 'நெருப்பு (Fire)',
                    'hi' => 'अग्नि (Fire)',
                ],
                'sanskrit' => 'Simha',
                'sign_overview' => [
                    'en' => 'Governed by Sun, Chingam solar natives possess regal dignity, magnetic authority, and generous hearts.',
                    'ml' => 'സൂര്യന്റെ സ്വന്തം രാശിയായ ചിങ്ങത്തിൽ ജനിച്ചവർ രാജകീയ പ്രൗഢിയും ഔദാര്യവും സ്വാഭാവിക അധികാരശക്തിയും ഉള്ളവരാണ്.',
                    'ta' => 'சூரியனின் ஆட்சி பெற்ற சிம்ம ராசிக்காரர்கள் கம்பீரமும், தாராள மனமும், ஆளுமைத் திறனும் கொண்டவர்கள்.',
                    'hi' => 'सूर्य की अपनी सिंह राशि के जातक राजसी ठाठ-बाट, उदार हृदय और नेतृत्व कौशल के धनी होते हैं।',
                ],
            ];
        } elseif (($m == 9 && $d >= 17) || ($m == 10 && $d <= 17)) {
            return [
                'name_ml' => 'കന്നി (Kanni)',
                'name_en' => 'Virgo (Kanni)',
                'name_ta' => 'கன்னி (Kanni)',
                'name_hi' => 'कन्या (Kanya)',
                'symbol' => '♍ Maiden',
                'element' => [
                    'en' => 'Earth (ഭൂമി)',
                    'ml' => 'ഭൂമി (Earth)',
                    'ta' => 'பூமி (Earth)',
                    'hi' => 'पृथ्वी (Earth)',
                ],
                'sanskrit' => 'Kanya',
                'sign_overview' => [
                    'en' => 'Governed by Mercury, Kanni solar natives are analytical, detail-oriented, service-minded, and methodical.',
                    'ml' => 'ബുധന്റെ ആധിപത്യമുള്ള കന്നി രാശിക്കാർ സൂക്ഷ്മനിരീക്ഷണപാടവവും കാര്യക്ഷമതയും സേവനമനോഭാവവുമുള്ളവരാണ്.',
                    'ta' => 'புதனின் ஆட்சி பெற்ற கன்னி ராசிக்காரர்கள் நுணுக்கமான புத்தி, சேவை மனப்பான்மை மற்றும் ஒழுங்குமுறை கொண்டவர்கள்.',
                    'hi' => 'बुध शासित कन्या राशि के जातक विश्लेषणात्मक, बारीकियों पर ध्यान देने वाले और सेवाभावी होते हैं।',
                ],
            ];
        } elseif (($m == 10 && $d >= 18) || ($m == 11 && $d <= 16)) {
            return [
                'name_ml' => 'തുലാം (Thulam)',
                'name_en' => 'Libra (Thulam)',
                'name_ta' => 'துலாம் (Thulam)',
                'name_hi' => 'तुला (Tula)',
                'symbol' => '♎ Scales',
                'element' => [
                    'en' => 'Air (വായു)',
                    'ml' => 'വായു (Air)',
                    'ta' => 'காற்று (Air)',
                    'hi' => 'वायु (Air)',
                ],
                'sanskrit' => 'Tula',
                'sign_overview' => [
                    'en' => 'Governed by Venus, Thulam solar natives seek harmony, balance, refined aesthetics, and diplomatic justice.',
                    'ml' => 'ശുക്രന്റെ ആധിപത്യമുള്ള തുലാം രാശിക്കാർ നീതിബോധവും സൗന്ദര്യസ്നേഹവും സമാധാനപ്രിയത്വവും ഉള്ളവരാണ്.',
                    'ta' => 'சுக்கிரனின் ஆட்சி பெற்ற துலாம் ராசிக்காரர்கள் சமநிலை, அழகுணர்ச்சி, நியாயம் மற்றும் அமைதியை விரும்புபவர்கள்.',
                    'hi' => 'शुक्र शासित तुला राशि के जातक संतुलन, न्याय, सौम्यता और शांतिप्रिय जीवन के पक्षधर होते हैं।',
                ],
            ];
        } elseif (($m == 11 && $d >= 17) || ($m == 12 && $d <= 15)) {
            return [
                'name_ml' => 'വൃശ്ചികം (Vrischikam)',
                'name_en' => 'Scorpio (Vrischikam)',
                'name_ta' => 'விருச்சிகம் (Vrischikam)',
                'name_hi' => 'वृश्चिक (Vrischika)',
                'symbol' => '♏ Scorpion',
                'element' => [
                    'en' => 'Water (ജലം)',
                    'ml' => 'ജലം (Water)',
                    'ta' => 'நீர் (Water)',
                    'hi' => 'जल (Water)',
                ],
                'sanskrit' => 'Vrischika',
                'sign_overview' => [
                    'en' => 'Governed by Mars, Vrischikam solar natives are intense, intuitive, transformative, and passionately loyal.',
                    'ml' => 'ചൊവ്വയുടെ ആധിപത്യമുള്ള വൃശ്ചികം രാശിക്കാർ ആഴമേറിയ മനക്കരുത്തും നിഗൂഢതയും അചഞ്ചലമായ ലക്ഷ്യബോധവുമുള്ളവരാണ്.',
                    'ta' => 'செவ்வாயின் ஆதிக்கம் பெற்ற விருச்சிக ராசிக்காரர்கள் தீவிர மன உறுதி, ஆழ்ந்த உள்ளுணர்வு மற்றும் எதையும் தாங்கும் சக்தி கொண்டவர்கள்.',
                    'hi' => 'मंगल शासित वृश्चिक राशि के जातक गहन, साहसी, रहस्यमयी और अटूट संकल्प शक्ति वाले होते हैं।',
                ],
            ];
        } elseif (($m == 12 && $d >= 16) || ($m == 1 && $d <= 13)) {
            return [
                'name_ml' => 'ധനു (Dhanu)',
                'name_en' => 'Sagittarius (Dhanu)',
                'name_ta' => 'தனுசு (Thanusu)',
                'name_hi' => 'धनु (Dhanu)',
                'symbol' => '♐ Archer',
                'element' => [
                    'en' => 'Fire (അഗ്നി)',
                    'ml' => 'അഗ്നി (Fire)',
                    'ta' => 'நெருப்பு (Fire)',
                    'hi' => 'अग्नि (Fire)',
                ],
                'sanskrit' => 'Dhanu',
                'sign_overview' => [
                    'en' => 'Governed by Jupiter, Dhanu solar natives are truth-seekers, optimistic, philosophical, and visionary explorers.',
                    'ml' => 'വ്യാഴത്തിന്റെ ആധിപത്യമുള്ള ധനു രാശിക്കാർ ജ്ഞാനദാഹികളും സത്യസന്ധരും ശുഭാപ്തിവിശ്വാസമുള്ളവരുമാണ്.',
                    'ta' => 'குருவின் ஆட்சி பெற்ற தனுசு ராசிக்காரர்கள் நேர்மை, ஆன்மீக நாட்டம், உயர் லட்சியங்கள் கொண்ட உன்னத மனிதர்கள்.',
                    'hi' => 'गुरु शासित धनु राशि के जातक सत्यवादी, आशावादी, दार्शनिक और उच्च आदर्शों वाले होते हैं।',
                ],
            ];
        } elseif (($m == 1 && $d >= 14) || ($m == 2 && $d <= 12)) {
            return [
                'name_ml' => 'മകരം (Makaram)',
                'name_en' => 'Capricorn (Makaram)',
                'name_ta' => 'மகரம் (Makaram)',
                'name_hi' => 'मकर (Makara)',
                'symbol' => '♑ Sea-Goat',
                'element' => [
                    'en' => 'Earth (ഭൂമി)',
                    'ml' => 'ഭൂമി (Earth)',
                    'ta' => 'பூமி (Earth)',
                    'hi' => 'पृथ्वी (Earth)',
                ],
                'sanskrit' => 'Makara',
                'sign_overview' => [
                    'en' => 'Governed by Saturn, Makaram solar natives are ambitious, disciplined, patient, and capable of scaling monumental heights.',
                    'ml' => 'ശനിയുടെ ആധിപത്യമുള്ള മകരം രാശിക്കാർ അച്ചടക്കവും ക്ഷമയും കഠിനാധ്വാനവും കൊണ്ട് ഉന്നത വിജയങ്ങൾ കൈവരിക്കുന്നവരാണ്.',
                    'ta' => 'சனியின் ஆட்சி பெற்ற மகர ராசிக்காரர்கள் விடாமுயற்சி, பொறுமை மற்றும் உயர்ந்த இலக்குகளை அடையும் வல்லமை கொண்டவர்கள்.',
                    'hi' => 'शनि शासित मकर राशि के जातक अनुशासित, महत्वाकांक्षी और कठिन परिश्रम से शिखर छूने वाले होते हैं।',
                ],
            ];
        } elseif (($m == 2 && $d >= 13) || ($m == 3 && $d <= 13)) {
            return [
                'name_ml' => 'കുംഭം (Kumbham)',
                'name_en' => 'Aquarius (Kumbham)',
                'name_ta' => 'கும்பம் (Kumbham)',
                'name_hi' => 'कुंभ (Kumbha)',
                'symbol' => '♒ Water-Bearer',
                'element' => [
                    'en' => 'Air (വായു)',
                    'ml' => 'വായു (Air)',
                    'ta' => 'காற்று (Air)',
                    'hi' => 'वायु (Air)',
                ],
                'sanskrit' => 'Kumbha',
                'sign_overview' => [
                    'en' => 'Governed by Saturn, Kumbham solar natives are visionary humanitarians, original thinkers, and reform-oriented minds.',
                    'ml' => 'ശനിയുടെ ആധിപത്യമുള്ള കുംഭം രാശിക്കാർ മാനവികതയും വേറിട്ട ചിന്താരീതികളും സമൂഹത്തിൽ മാറ്റങ്ങൾ കൊണ്ടുവരാനുള്ള ആഗ്രഹവുമുള്ളവരാണ്.',
                    'ta' => 'சனியின் ஆட்சி பெற்ற கும்ப ராசிக்காரர்கள் முற்போக்கு சிந்தனை, மனிதநேயம் மற்றும் புதுமைகளைப் புகுத்தும் ஆர்வம் கொண்டவர்கள்.',
                    'hi' => 'शनि शासित कुंभ राशि के जातक मानवतावादी, मौलिक विचारक और समाज सुधारक दृष्टि वाले होते हैं।',
                ],
            ];
        } else {
            return [
                'name_ml' => 'മീനം (Meenam)',
                'name_en' => 'Pisces (Meenam)',
                'name_ta' => 'மீனம் (Meenam)',
                'name_hi' => 'मीन (Meena)',
                'symbol' => '♓ Two Fishes',
                'element' => [
                    'en' => 'Water (ജലം)',
                    'ml' => 'ജലം (Water)',
                    'ta' => 'நீர் (Water)',
                    'hi' => 'जल (Water)',
                ],
                'sanskrit' => 'Meena',
                'sign_overview' => [
                    'en' => 'Governed by Jupiter, Meenam solar natives are compassionate, imaginative, spiritually inclined, and selfless.',
                    'ml' => 'വ്യാഴത്തിന്റെ ആധിപത്യമുള്ള മീനം രാശിക്കാർ ദയാലുക്കളും ഭാവനാസമ്പന്നരും ആത്മീയ ചിന്താഗതിക്കാരുമാണ്.',
                    'ta' => 'குருவின் ஆட்சி பெற்ற மீன ராசிக்காரர்கள் கருணை, கற்பனைத் திறன் மற்றும் ஆன்மீக பக்தி நிறைந்தவர்கள்.',
                    'hi' => 'गुरु शासित मीन राशि के जातक दयालु, परोपकारी, कल्पनाशील और आध्यात्मिक स्वभाव वाले होते हैं।',
                ],
            ];
        }
    }
}
