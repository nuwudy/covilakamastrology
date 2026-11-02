<?php

namespace Database\Seeders;

use App\Models\VedangaRule;
use Illuminate\Database\Seeder;

class VedangaJyothishamRulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rules = array_merge(
            $this->getGulikaHouseRules(),
            $this->getGulikaConjunctionRules(),
            $this->getYogaRules(),
            $this->getDiagnosticRules(),
            $this->getPlanetsInHousesRules(),
            $this->getLordsInHousesRules()
        );

        foreach ($rules as $rule) {
            VedangaRule::updateOrCreate(
                [
                    'category' => $rule['category'],
                    'rule_key' => $rule['rule_key'],
                ],
                [
                    'content_en' => $rule['content_en'],
                    'content_ml' => $rule['content_ml'],
                    'content_ta' => $rule['content_ta'] ?? $rule['content_en'],
                    'content_hi' => $rule['content_hi'] ?? $rule['content_en'],
                    'metadata' => $rule['metadata'] ?? null,
                ]
            );
        }
    }

    /**
     * Chapter 5 & 17: Gulika in Houses 1 to 12 (Pages 34–35 & 100).
     */
    protected function getGulikaHouseRules(): array
    {
        return [
            [
                'category' => 'gulika_house',
                'rule_key' => 'gulika_H1',
                'content_en' => 'Gulika in 1st House (Lagna): Endows high self-will and magnetic presence. When solitary in Ascendant (Ch. 17, p. 100), it confers Rajayoga, vehicle ownership, and worldly respect. Minor restlessness or bodily heat is neutralized through daily prayer and wearing cooling gemstones.',
                'content_ml' => 'ഒന്നാം ഭാവത്തിൽ (ലഗ്നത്തിൽ) ഗുളികൻ: ശക്തമായ ഇച്ഛാശക്തിയും വ്യക്തിപ്രഭാവവും. ലഗ്നത്തിൽ ഗുളികൻ തനിച്ചു നിന്നാൽ (അധ്യായം 17, പേജ് 100) രാജയോഗം, വാഹനാദി സൗഭാഗ്യങ്ങൾ, മാന്യത എന്നിവ ഫലം. നേരിയ അസ്വസ്ഥതകൾ ഈശ്വര പ്രാർത്ഥനയാലും ശീതള രത്നധാരണത്താലും നിഷ്പ്രഭമാകും.',
                'content_ta' => 'லக்னத்தில் குளிகன்: தீவிர மன உறுதி மற்றும் ஆளுமை. சுப யோகம் மற்றும் வாகன பாக்கியம் தரும். மன அமைதிக்கு இறை வழிபாடு நலம் பயக்கும்.',
                'content_hi' => 'लग्न में गुलिक: दृढ़ संकल्प और प्रभावशीलता। शुभ दृष्टि होने पर राजयोग, वाहन सुख और सम्मान प्राप्त होता है।',
                'metadata' => ['house' => 1, 'chapter' => 5, 'page' => 34],
            ],
            [
                'category' => 'gulika_house',
                'rule_key' => 'gulika_H2',
                'content_en' => 'Gulika in 2nd House: Indicates sharp or frank speech, fluctuating finances, and love for gourmet food. Practicing mindful diplomacy and maintaining disciplined savings ensures lasting financial stability.',
                'content_ml' => 'രണ്ടാം ഭാവത്തിൽ ഗുളികൻ: വ്യക്തവും ശക്തവുമായ വാക്ക്, ധനത്തിൽ ഏറ്റക്കുറച്ചിലുകൾ, രുചികരമായ ഭക്ഷണ പ്രിയം. വിവേകപൂർവ്വമായ സംസാരവും സാമ്പത്തിക അച്ചടക്കവും ഐശ്വര്യം ഉറപ്പാക്കും.',
                'content_ta' => '2-ஆம் வீட்டில் குளிகன்: நேரடியான பேச்சு, நிதி ஏற்றத்தாழ்வுகள். நிதி நிர்வாகமும் சாதுரிய பேச்சும் நன்மை தரும்.',
                'content_hi' => 'द्वितीय भाव में गुलिक: स्पष्ट वाणी एवं धन प्रवाह में उतार-चढ़ाव। वाणी पर नियंत्रण एवं बचत से समृद्धि मिलती है।',
                'metadata' => ['house' => 2, 'chapter' => 5, 'page' => 34],
            ],
            [
                'category' => 'gulika_house',
                'rule_key' => 'gulika_H3',
                'content_en' => 'Gulika in 3rd House: Fearlessness, immense valor, enterprise, and energetic independence. With Jupiter, confers distinguished teaching capability and literary renown.',
                'content_ml' => 'മൂന്നാം ഭാവത്തിൽ ഗുളികൻ: നിർഭയത്വം, അസാധാരണമായ ധൈര്യം, പരിശ്രമശീലം, സഹോദരങ്ങളിൽ നിന്ന് വേറിട്ട സ്വതന്ത്ര നിലപാട്. വ്യാഴ സംബന്ധമുണ്ടായാൽ വിശിഷ്ട അധ്യാപകനോ എഴുത്തുകാരനോ ആകും.',
                'content_ta' => '3-ஆம் வீட்டில் குளிகன்: அஞ்சாநெஞ்சம், வீரம் மற்றும் முயற்சி. குரு தொடர்பு இருந்தால் சிறந்த ஆசிரியர் அல்லது வழிகாட்டியாக திகழ்வர்.',
                'content_hi' => 'तृतीय भाव में गुलिक: पराक्रम, निर्भीकता एवं स्वतंत्र कार्यशैली। गुरु दृष्टि से उत्तम उपदेशक बनते हैं।',
                'metadata' => ['house' => 3, 'chapter' => 5, 'page' => 34],
            ],
            [
                'category' => 'gulika_house',
                'rule_key' => 'gulika_H4',
                'content_en' => 'Gulika in 4th House: Sensitive domestic atmosphere in early youth; calls for attentive vehicle maintenance and devotion to maternal wellness. Auspicious aspects dissolve obstacles, bringing domestic peace.',
                'content_ml' => 'നാലാം ഭാവത്തിൽ ഗുളികൻ: ഗൃഹസുഖത്തിലും വാഹനങ്ങളിലും ജാഗ്രത പുലർത്തുന്നത് ഉത്തമം. മാതൃസേവയും ശുഭഗ്രഹ കടാക്ഷവും കുടുംബത്തിൽ ഐശ്വര്യവും മനശ്ശാന്തിയും നിറയ്ക്കും.',
                'content_ta' => '4-ஆம் வீட்டில் குளிகன்: குடும்ப நலம் மற்றும் வாகன பராமரிப்பில் கவனம் தேவை. தாய் அன்பும் வழிபாடும் நலம் பயக்கும்.',
                'content_hi' => 'चतुर्थ भाव में गुलिक: पारिवारिक सुख एवं वाहन में सावधानी। माता की सेवा एवं शुभ ग्रहों की दृष्टि से सुख मिलता है।',
                'metadata' => ['house' => 4, 'chapter' => 5, 'page' => 34],
            ],
            [
                'category' => 'gulika_house',
                'rule_key' => 'gulika_H5',
                'content_en' => 'Gulika in 5th House: Intuitive mind with sudden intellectual leaps; requires calm focus and dedicated spiritual remedies for progeny welfare and mental tranquility.',
                'content_ml' => 'അഞ്ചാം ഭാവത്തിൽ ഗുളികൻ: ഭാവനാസമ്പന്നമായ മനസ്സ്, ബുദ്ധിയിൽ അവിചാരിത ചിന്തകൾ. സന്താനക്ഷേമത്തിനും മനശ്ശാന്തിക്കുമായി ഈശ്വര ഉപാസനയും സത്സംഗവും നിർദ്ദേശിക്കുന്നു.',
                'content_ta' => '5-ஆம் வீட்டில் குளிகன்: கூர்மையான அறிவு. சந்தான மேன்மைக்கும் மன அமைதிக்கும் இஷ்ட தெய்வ வழிபாடு உத்தமம்.',
                'content_hi' => 'पंचम भाव में गुलिक: तीक्ष्ण बुद्धि। संतान सुख एवं मानसिक शांति के लिए आध्यात्मिक साधना श्रेयस्कर है।',
                'metadata' => ['house' => 5, 'chapter' => 5, 'page' => 34],
            ],
            [
                'category' => 'gulika_house',
                'rule_key' => 'gulika_H6',
                'content_en' => 'Gulika in 6th House: Highly auspicious (*Shubha Phala*)! Grants commanding courage, mastery over disputes, high immunity, professional triumph, and financial ascent.',
                'content_ml' => 'ആറാം ഭാവത്തിൽ ഗുളികൻ: അത്യന്തം ശുഭകരം! ശത്രുജയം, സർവ്വകാര്യ വിജയം, ഉന്നത പ്രതിരോധശേഷി, ദൃഢനിശ്ചയം, സാമ്പത്തിക ഉന്നതി എന്നിവ സമ്മാനിക്കുന്നു.',
                'content_ta' => '6-ஆம் வீட்டில் குளிகன்: மிகவும் சுபமானது! எதிரிகள் வெற்றி, தைரியம், நல்ல ஆரோக்கியம் மற்றும் தொழில் மேன்மை தரும்.',
                'content_hi' => 'षष्ठ भाव में गुलिक: अत्यंत शुभ फलदायक! शत्रु विजय, उत्तम स्वास्थ्य, पराक्रम और आर्थिक उन्नति प्रदान करता है।',
                'metadata' => ['house' => 6, 'chapter' => 5, 'page' => 34],
            ],
            [
                'category' => 'gulika_house',
                'rule_key' => 'gulika_H7',
                'content_en' => 'Gulika in 7th House: Advises conscious harmony, empathetic communication in marital partnerships, and transparent contractual agreements for enduring success.',
                'content_ml' => 'ഏഴാം ഭാവത്തിൽ ഗുളികൻ: ദാമ്പത്യത്തിലും കൂട്ടുകച്ചവടത്തിലും ക്ഷമയും സഹിഷ്ണുതയും പക്വമായ ആശയവിനിമയവും വളർത്തുന്നത് ദീർഘകാല വിജയത്തിനും ഐക്യത്തിനും വഴിതെളിക്കും.',
                'content_ta' => '7-ஆம் வீட்டில் குளிகன்: திருமண வாழ்க்கையிலும் கூட்டுத் தொழிலும் விட்டுக்கொடுத்து போதல் நீண்டகால மகிழ்ச்சி தரும்.',
                'content_hi' => 'सप्तम भाव में गुलिक: वैवाहिक जीवन एवं साझेदारी में धैर्य और परस्पर समझ से स्थायित्व आता है।',
                'metadata' => ['house' => 7, 'chapter' => 5, 'page' => 34],
            ],
            [
                'category' => 'gulika_house',
                'rule_key' => 'gulika_H8',
                'content_en' => 'Gulika in 8th House: Recommends proactive health consciousness, balanced dietary rhythms, and spiritual longevity pariharams; benefic aspects completely avert challenges.',
                'content_ml' => 'എട്ടാം ഭാവത്തിൽ ഗുളികൻ: ദിനചര്യകളിലും ആരോഗ്യ സംരക്ഷണത്തിലും കരുതൽ പുലർത്തുക. ആയുർവേദ ചിട്ടകളും ശിവ/ശാസ്താ ഭജനവും ദീർഘായുസ്സും ഓജസ്സും പ്രദാനം ചെയ്യും.',
                'content_ta' => '8-ஆம் வீட்டில் குளிகன்: ஆரோக்கியத்தில் விழிப்புணர்வும், சிவ/சாஸ்தா வழிபாடும் நீண்ட ஆயுளையும் நன்மையும் தரும்.',
                'content_hi' => 'अष्टम भाव में गुलिक: स्वास्थ्य के प्रति सजगता एवं सात्विक दिनचर्या आवश्यक। शिव उपासना से दीर्घायु की प्राप्ति होती है।',
                'metadata' => ['house' => 8, 'chapter' => 5, 'page' => 34],
            ],
            [
                'category' => 'gulika_house',
                'rule_key' => 'gulika_H9',
                'content_en' => 'Gulika in 9th House: Independent spiritual views, potential foreign travels, and self-made fortunes. Honoring teachers and ancestral rites unlocks profound fortune.',
                'content_ml' => 'ഒൻപതാം ഭാവത്തിൽ ഗുളികൻ: സ്വതന്ത്രമായ ആത്മീയ വീക്ഷണം, വിദേശ യാത്രകൾ. പിതൃതർപ്പണവും ഗുരുഭക്തിയും ഈശ്വരാനുഗ്രഹവും ഭാഗ്യകവാടങ്ങൾ തുറക്കും.',
                'content_ta' => '9-ஆம் வீட்டில் குளிகன்: சுய சிந்தனை, வெளிநாட்டு யோகம். முன்னோர்கள் ஆசியும் குரு பக்தியும் பெரும் பாக்கியம் தரும்.',
                'content_hi' => 'नवम भाव में गुलिक: स्वतंत्र धार्मिक दृष्टिकोण एवं विदेश गमन। गुरुजनों का सम्मान एवं पितृ शांति से भाग्य चमकता है।',
                'metadata' => ['house' => 9, 'chapter' => 5, 'page' => 34],
            ],
            [
                'category' => 'gulika_house',
                'rule_key' => 'gulika_H10',
                'content_en' => 'Gulika in 10th House: Diligent work ethic, practical execution, and responsibility. Under favorable planetary aspects, rises to become a respected mentor or organizational leader.',
                'content_ml' => 'പത്താം ഭാവത്തിൽ ഗുളികൻ: കർമ്മരംഗത്ത് കഠിനാധ്വാനവും ഉത്തരവാദിത്തബോധവും. ശുഭഗ്രഹ സംബന്ധത്താൽ ഉന്നത പദവി, നേതൃത്വം, ആദരണീയമായ ഉപദേശക സ്ഥാനം എന്നിവ ലഭിക്കും.',
                'content_ta' => '10-ஆம் வீட்டில் குளிகன்: கடின உழைப்பு மற்றும் பொறுப்புணர்வு. சுப தொடர்பால் தொழிலில் உயர்ந்த அந்தஸ்து பெறுவர்.',
                'content_hi' => 'दशम भाव में गुलिक: कर्मठ स्वभाव एवं कर्तव्यनिष्ठा। शुभ दृष्टि से कार्यक्षेत्र में उच्च पद और प्रतिष्ठा मिलती है।',
                'metadata' => ['house' => 10, 'chapter' => 5, 'page' => 35],
            ],
            [
                'category' => 'gulika_house',
                'rule_key' => 'gulika_H11',
                'content_en' => 'Gulika in 11th House: Highly auspicious (*Yogaprada*)! Endows wealth accumulation, influential friendships, charismatic charm, comfortable lifestyle, and thriving progeny.',
                'content_ml' => 'പതിനൊന്നാം ഭാവത്തിൽ ഗുളികൻ: അത്യന്തം ഭാഗ്യപ്രദം (യോഗപ്രദൻ)! സമ്പൽസമൃദ്ധി, വിശിഷ്ട വ്യക്തികളുമായുള്ള സൗഹൃദം, സുഖസൗകര്യങ്ങൾ, സൽസന്താനങ്ങൾ എന്നിവ ഫലം.',
                'content_ta' => '11-ஆம் வீட்டில் குளிகன்: மகா சுபயோகம்! பணவரவு, செல்வாக்கு, சகல சௌபாக்கியங்கள் மற்றும் நற்குழந்தைகள் அமையும்.',
                'content_hi' => 'एकादश भाव में गुलिक: अत्यंत शुभ योगप्रद! धन लाभ, उच्च मित्रों का सहयोग, ऐश्वर्य एवं योग्य संतान की प्राप्ति होती है।',
                'metadata' => ['house' => 11, 'chapter' => 5, 'page' => 35],
            ],
            [
                'category' => 'gulika_house',
                'rule_key' => 'gulika_H12',
                'content_en' => 'Gulika in 12th House: Inclination toward overseas travel, philanthropy, and varied expenses. Practicing planned expenditure and yogic meditation brings profound inner peace.',
                'content_ml' => 'പന്ത്രണ്ടാം ഭാവത്തിൽ ഗുളികൻ: വിദേശ വാസ താല്പര്യം, ജീവകാരുണ്യ പ്രവർത്തനങ്ങൾ, വർദ്ധിച്ച വ്യയം. ആസൂത്രിത സാമ്പത്തിക ചിട്ടയും ധ്യാനവും മനസ്സിന് ശാന്തി നൽകും.',
                'content_ta' => '12-ஆம் வீட்டில் குளிகன்: வெளிநாட்டுப் பயணம், தான தர்மங்கள், செலவுகள். முறையான திட்டமிடலும் தியானமும் அமைதி தரும்.',
                'content_hi' => 'द्वादश भाव में गुलिक: विदेश यात्रा, दान-पुण्य एवं व्यय। सुनियोजित बजट एवं ध्यान से मानसिक शांति मिलती है।',
                'metadata' => ['house' => 12, 'chapter' => 5, 'page' => 35],
            ],
        ];
    }

    /**
     * Chapter 5: Gulika Conjunctions (Page 35).
     */
    protected function getGulikaConjunctionRules(): array
    {
        return [
            [
                'category' => 'gulika_conjunction',
                'rule_key' => 'gulika_conj_Su',
                'content_en' => 'Gulika conjunct Sun: Calls for dedicated care toward paternal harmony and bone/vitality health. Sunday Surya Namaskar and Aditya Hridaya Stotram offer strong protective grace.',
                'content_ml' => 'സൂര്യ-ഗുളിക സംയോജനം: പിതൃബന്ധത്തിലും അസ്ഥി/നേത്ര ആരോഗ്യത്തിലും ശ്രദ്ധിക്കുക. ഞായറാഴ്ച സൂര്യനമസ്കാരവും ആദിത്യഹൃദയ ജപവും ഐശ്വര്യം നൽകും.',
                'content_ta' => 'சூரியன் - குளிகன் சேர்க்கை: தந்தை நலன் மற்றும் கண் ஆரோக்கியத்தில் கவனம் தேவை. சூரிய நமஸ்காரம் பலன் தரும்.',
                'content_hi' => 'सूर्य-गुलिक युति: पिता के स्वास्थ्य एवं नेत्र ज्योति के प्रति सावधानी। रविवार को आदित्य हृदय स्तोत्र शुभ है।',
                'metadata' => ['planet' => 'Su', 'chapter' => 5, 'page' => 35],
            ],
            [
                'category' => 'gulika_conjunction',
                'rule_key' => 'gulika_conj_Mo',
                'content_en' => 'Gulika conjunct Moon: Deeply receptive emotional radar; meditation and hydration maintain calm resilience during fluctuating lunar phases.',
                'content_ml' => 'ചന്ദ്ര-ഗുളിക സംയോജനം: അതിലോലമായ വികാരങ്ങൾ. ധ്യാനവും പ്രാണായാമവും പാർവ്വതീ പൂജയും മാനസികമായ ദൃഢതയും തെളിമയും സമ്മാനിക്കും.',
                'content_ta' => 'சந்திரன் - குளிகன் சேர்க்கை: உணர்ச்சிவசப்படும் குணம். தியானமும் அம்பாள் வழிபாடும் மன அமைதியைத் தரும்.',
                'content_hi' => 'चन्द्र-गुलिक युति: संवेदनशील मन। ध्यान एवं शिव-पार्वती उपासना से मानसिक संतुलन और शांति प्राप्त होती है।',
                'metadata' => ['planet' => 'Mo', 'chapter' => 5, 'page' => 35],
            ],
            [
                'category' => 'gulika_conjunction',
                'rule_key' => 'gulika_conj_Ma',
                'content_en' => 'Gulika conjunct Mars: High passionate drive; directs energy constructively into sports, engineering, or leadership rather than verbal friction with peers.',
                'content_ml' => 'ചൊവ്വ-ഗുളിക സംയോജനം: അത്യുത്സാഹവും അഗ്നിസ്വഭാവവും. ഈ ഊർജ്ജത്തെ കായികരംഗത്തോ സാങ്കേതിക തൊഴിലുകളിലോ വിനിയോഗിക്കുന്നത് ഉന്നത വിജയം നൽകും.',
                'content_ta' => 'செவ்வாய் - குளிகன் சேர்க்கை: தீவிர ஆற்றல். கோபத்தைத் தவிர்த்து ஆக்கப்பூர்வமான காரியங்களில் ஈடுபடுவது வெற்றி தரும்.',
                'content_hi' => 'मंगल-गुलिक युति: अत्यधिक ऊर्जा। क्रोध पर नियंत्रण रखकर इसे तकनीकी या नेतृत्व कार्यों में लगाना चाहिए।',
                'metadata' => ['planet' => 'Ma', 'chapter' => 5, 'page' => 35],
            ],
            [
                'category' => 'gulika_conjunction',
                'rule_key' => 'gulika_conj_Me',
                'content_en' => 'Gulika conjunct Mercury: Sharp analytical mind; brief breaks during intense analytical work prevent mental fatigue and enhance creative clarity.',
                'content_ml' => 'ബുധ-ഗുളിക സംയോജനം: അതിസൂക്ഷ്മമായ ബുദ്ധിവൈഭവം. അമിത ചിന്തകൾ ഒഴിവാക്കി മനസ്സിന് വിശ്രമം നൽകുന്നത് ബുദ്ധിയുടെ തിളക്കം വർദ്ധിപ്പിക്കും.',
                'content_ta' => 'புதன் - குளிகன் சேர்க்கை: கூர்மையான அறிவுத்திறன். அதிக சிந்தனையைத் தவிர்ப்பது மனத்தெளிவைத் தரும்.',
                'content_hi' => 'बुध-गुलिक युति: तीव्र विश्लेषणात्मक बुद्धि। अधिक तनाव से बचकर सकारात्मक सोच बनाए रखना लाभदायक है।',
                'metadata' => ['planet' => 'Me', 'chapter' => 5, 'page' => 35],
            ],
            [
                'category' => 'gulika_conjunction',
                'rule_key' => 'gulika_conj_Ju',
                'content_en' => 'Gulika conjunct Jupiter: Philosophical wisdom; authentic ethical practice and honoring genuine preceptors brings divine expansion.',
                'content_ml' => 'വ്യാഴ-ഗുളിക സംയോജനം: ആത്മീയ ജ്ഞാനം. സദാചാര നിഷ്ഠയും ഗുരുസേവയും ശ്രേഷ്ഠമായ ഈശ്വരാനുഗ്രഹം പ്രദാനം ചെയ്യും.',
                'content_ta' => 'குரு - குளிகன் சேர்க்கை: ஆன்மீக நாட்டம். பெரியோர்கள் ஆசியும் குரு பக்தியும் மேன்மை தரும்.',
                'content_hi' => 'गुरु-गुलिक युति: दार्शनिक ज्ञान। सदाचार एवं गुरु की सेवा से आध्यात्मिक और भौतिक उन्नति होती है।',
                'metadata' => ['planet' => 'Ju', 'chapter' => 5, 'page' => 35],
            ],
            [
                'category' => 'gulika_conjunction',
                'rule_key' => 'gulika_conj_Ve',
                'content_en' => 'Gulika conjunct Venus: Artistic flair; mindful discernment in partnerships and dietary moderation ensures long-term relationship happiness.',
                'content_ml' => 'ശുക്ര-ഗുളിക സംയോജനം: കലാവാസനയും സൗന്ദര്യബോധവും. പങ്കാളിയുമായുള്ള ആശയവിനിമയത്തിൽ വിട്ടുവീഴ്ചയും സ്നേഹവും നിലനിർത്തുക.',
                'content_ta' => 'சுக்கிரன் - குளிகன் சேர்க்கை: கலை ஆர்வம். உறவுகளில் வெளிப்படைத்தன்மையும் நல்லெண்ணமும் மகிழ்ச்சி தரும்.',
                'content_hi' => 'शुक्र-गुलिक युति: कलात्मक रुचि। दांपत्य जीवन में स्पष्ट संवाद एवं सात्विक जीवनशैली से सुख बढ़ता है।',
                'metadata' => ['planet' => 'Ve', 'chapter' => 5, 'page' => 35],
            ],
            [
                'category' => 'gulika_conjunction',
                'rule_key' => 'gulika_conj_Sa',
                'content_en' => 'Gulika conjunct Saturn: Enduring patience; regular exercise and Ayyappa/Shasta worship removes heaviness and yields monumental career endurance.',
                'content_ml' => 'ശനി-ഗുളിക സംയോജനം: ക്ഷമയും സഹിഷ്ണുതയും. കഠിനാധ്വാനവും ശാസ്താ പ്രാർത്ഥനയും തൊഴിൽരംഗത്ത് അചഞ്ചലമായ ഉയർച്ച നൽകും.',
                'content_ta' => 'சனி - குளிகன் சேர்க்கை: விடாமுயற்சி மற்றும் பொறுமை. சாஸ்தா வழிபாடு தொழிலில் நிலையான வெற்றியைத் தரும்.',
                'content_hi' => 'शनि-गुलिक युति: धैर्य एवं सहनशीलता। नियमित व्यायाम एवं भगवान अय्यप्पा/शिव उपासना से करियर में स्थिरता आती है।',
                'metadata' => ['planet' => 'Sa', 'chapter' => 5, 'page' => 35],
            ],
            [
                'category' => 'gulika_conjunction',
                'rule_key' => 'gulika_conj_Ra',
                'content_en' => 'Gulika conjunct Rahu: Unconventional visionary; temple visits (Nagaraja/Subrahmanya) channel high speculative instincts into groundbreaking achievements.',
                'content_ml' => 'രാഹു-ഗുളിക സംയോജനം: വേറിട്ട ഭാവനയും സാഹസികതയും. നാഗരാജ/സുബ്രഹ്മണ്യ ഭജനം വിഷാദങ്ങളെ അകറ്റി വിസ്മയകരമായ പുരോഗതിയിലേക്ക് നയിക്കും.',
                'content_ta' => 'ராகு - குளிகன் சேர்க்கை: அசாதாரண கற்பனைத்திறன். நாகர் மற்றும் முருக வழிபாடு தடைகளை நீக்கி வெற்றி தரும்.',
                'content_hi' => 'राहु-गुलिक युति: नवीन एवं साहसी सोच। नाग देवता एवं कार्तिकेय की उपासना से विशेष सफलता मिलती है।',
                'metadata' => ['planet' => 'Ra', 'chapter' => 5, 'page' => 35],
            ],
            [
                'category' => 'gulika_conjunction',
                'rule_key' => 'gulika_conj_Ke',
                'content_en' => 'Gulika conjunct Ketu: Mystical intuition; regular meditation and Ganapathy homam turn spiritual curiosity into profound inner peace.',
                'content_ml' => 'കേതു-ഗുളിക സംയോജനം: നിഗൂഢ ശാസ്ത്ര താല്പര്യം, ആത്മീയ അന്തർജ്ഞാനം. ഗണപതി ഹോമവും ധ്യാനവും മനസ്സിന് ശാന്തിയും വിവേകവും നൽകും.',
                'content_ta' => 'கேது - குளிகன் சேர்க்கை: ஆன்மீக உள்ளுணர்வு. கணபதி வழிபாடு மற்றும் தியானம் மன அமைதியைத் தரும்.',
                'content_hi' => 'केतु-गुलिक युति: आध्यात्मिक अंतर्दृष्टि। गणेश जी की आराधना एवं ध्यान से आंतरिक शांति और ज्ञान मिलता है।',
                'metadata' => ['planet' => 'Ke', 'chapter' => 5, 'page' => 35],
            ],
        ];
    }

    /**
     * Chapter 10 & 13: Classical Yogas & Exceptions (Pages 54–56 & 70–72).
     */
    protected function getYogaRules(): array
    {
        return [
            [
                'category' => 'yoga',
                'rule_key' => 'ruchaka_yoga',
                'content_en' => 'Ruchaka Mahapurusha Yoga (Mars in Kendra in Own/Exaltation sign, non-Dual Lagna): Endows fearless leadership, commanding physical vitality, real estate success, and victory in competitive ventures.',
                'content_ml' => 'രുചക മഹാപുരുഷ യോഗം (ചൊവ്വ കേന്ദ്രത്തിൽ സ്വക്ഷേത്രത്തിലോ ഉച്ചത്തിലോ, ഉഭയ ലഗ്നമൊഴികെ): നിർഭയമായ നേതൃപാടവം, മികച്ച കായികക്ഷമത, ഭൂസ്വത്ത്, എതിർപ്പുകളെ അതിജീവിക്കാനുള്ള മനക്കരുത്ത്.',
                'content_ta' => 'ருசக யோகம்: தலைமைப் பண்பு, வீரம், நிலம் மற்றும் சொத்து சேர்க்கை, போட்டிகளில் வெற்றி.',
                'content_hi' => 'रुचक महापुरुष योग: साहसिक नेतृत्व, उत्तम स्वास्थ्य, भूमि-भवन का लाभ एवं प्रतियोगिताओं में विजय।',
                'metadata' => ['type' => 'panchamahapurusha', 'planet' => 'Ma', 'chapter' => 10, 'page' => 54],
            ],
            [
                'category' => 'yoga',
                'rule_key' => 'bhadra_yoga',
                'content_en' => 'Bhadra Mahapurusha Yoga (Mercury in Kendra in Own/Exaltation sign, Dual Lagna): Bestows formidable intellectual brilliance, mathematical eloquence, diplomatic acumen, and lasting professional fame.',
                'content_ml' => 'ഭദ്ര മഹാപുരുഷ യോഗം (ബുധൻ കേന്ദ്രത്തിൽ സ്വക്ഷേത്രത്തിലോ ഉച്ചത്തിലോ, ഉഭയ ലഗ്നത്തിൽ): അസാധാരണ ബുദ്ധിശക്തി, ഗണിത-ശാസ്ത്ര സാമർത്ഥ്യം, വാഗ്വിലാസം, ഉയർന്ന പ്രശസ്തി.',
                'content_ta' => 'பத்ர யோகம்: நுண்ணறிவு, பேச்சாற்றல், கணக்கியல் தேர்ச்சி மற்றும் உலகளாவிய புகழ்.',
                'content_hi' => 'भद्र महापुरुष योग: कुशाग्र बुद्धि, वाकपटुता, व्यापारिक दक्षता एवं समाज में आदर।',
                'metadata' => ['type' => 'panchamahapurusha', 'planet' => 'Me', 'chapter' => 10, 'page' => 54],
            ],
            [
                'category' => 'yoga',
                'rule_key' => 'hamsa_yoga',
                'content_en' => 'Hamsa Mahapurusha Yoga (Jupiter in Kendra in Own/Exaltation sign, non-Fixed Lagna): Endows moral stature, righteous prosperity, universal respect, philosophical mastery, and divine protection.',
                'content_ml' => 'ഹംസ മഹാപുരുഷ യോഗം (വ്യാഴം കേന്ദ്രത്തിൽ സ്വക്ഷേത്രത്തിലോ ഉച്ചത്തിലോ, സ്ഥിര ലഗ്നമൊഴികെ): ഉന്നത സദാചാരബോധം, ധർമ്മിഷ്ഠമായ ധനം, ജ്ഞാനം, സർവ്വാദരണീയമായ പദവി.',
                'content_ta' => 'ஹம்ச யோகம்: ஆன்மீக ஞானம், தர்ம சிந்தனை, சமூக மரியாதை மற்றும் சகல ஐஸ்வர்யம்.',
                'content_hi' => 'हंस महापुरुष योग: धार्मिक आचरण, उच्च ज्ञान, प्रतिष्ठा एवं ईश्वरीय कृपा से पूर्ण जीवन।',
                'metadata' => ['type' => 'panchamahapurusha', 'planet' => 'Ju', 'chapter' => 10, 'page' => 54],
            ],
            [
                'category' => 'yoga',
                'rule_key' => 'malavya_yoga',
                'content_en' => 'Malavya Mahapurusha Yoga (Venus in Kendra in Own/Exaltation sign): Grants aesthetic elegance, marital fulfillment, luxurious vehicles, artistic recognition, and joyful family living.',
                'content_ml' => 'മാളവ്യ മഹാപുരുഷ യോഗം (ശുക്രൻ കേന്ദ്രത്തിൽ സ്വക്ഷേത്രത്തിലോ ഉച്ചത്തിലോ): സൗന്ദര്യബോധം, സന്തുഷ്ട ദാമ്പത്യം, വാഹനാദി ആഡംബരങ്ങൾ, കലാവിജയം.',
                'content_ta' => 'மாளவ்ய யோகம்: கலை ஈடுபாடு, வாகன யோகம், குடும்ப அமைதி மற்றும் மகிழ்ச்சியான வாழ்க்கை.',
                'content_hi' => 'मालव्य महापुरुष योग: भौतिक सुख-सुविधाएं, वैवाहिक आनंद, वाहन सुख एवं कला क्षेत्र में ख्याति।',
                'metadata' => ['type' => 'panchamahapurusha', 'planet' => 'Ve', 'chapter' => 10, 'page' => 55],
            ],
            [
                'category' => 'yoga',
                'rule_key' => 'shasha_yoga',
                'content_en' => 'Shasha Mahapurusha Yoga (Saturn in Kendra in Own/Exaltation sign, non-Dual Lagna): Bestows enduring perseverance, administrative authority, devotion to maternal ideals, and mastery over land/mass organizations.',
                'content_ml' => 'ശശ മഹാപുരുഷ യോഗം (ശനി കേന്ദ്രത്തിൽ സ്വക്ഷേത്രത്തിലോ ഉച്ചത്തിലോ, ഉഭയ ലഗ്നമൊഴികെ): അചഞ്ചലമായ സ്ഥിരോത്സാഹം, ഭരണാധികാരം, ജനപിന്തുണ, ഭൂസ്വത്ത്.',
                'content_ta' => 'சச யோகம்: விடாமுயற்சி, பொதுஜன ஆதரவு, தலைமைப் பதவி மற்றும் பூமி யோகம்.',
                'content_hi' => 'शश महापुरुष योग: कठिन परिश्रम, जनसमूह पर अधिकार, नेतृत्व क्षमता एवं भूमि लाभ।',
                'metadata' => ['type' => 'panchamahapurusha', 'planet' => 'Sa', 'chapter' => 10, 'page' => 55],
            ],
            [
                'category' => 'yoga',
                'rule_key' => 'gajakesari_yoga',
                'content_en' => 'Gajakesari Yoga (Jupiter in Kendra from Moon): Royal elephant-lion combination conferring enduring name, noble virtue, unshakeable dignity, and victory over adversaries.',
                'content_ml' => 'ഗജകേസരി യോഗം (ചന്ദ്രനിൽ നിന്ന് വ്യാഴം കേന്ദ്രത്തിൽ): അചഞ്ചലമായ കീർത്തി, സൽസ്വഭാവം, പ്രതിസന്ധികളിൽ സിംഹതുല്യമായ വിജയം, ദൈവാനുഗ്രഹം.',
                'content_ta' => 'கஜகேசரி யோகம்: நிலையான புகழ், வெற்றி, நற்குணங்கள் மற்றும் செல்வச் செழிப்பு.',
                'content_hi' => 'गजकेसरी योग: स्थायी यश, मान-प्रतिष्ठा, शत्रुओं पर विजय एवं दीर्घकालिक समृद्धि।',
                'metadata' => ['type' => 'lunar', 'chapter' => 10, 'page' => 55],
            ],
            [
                'category' => 'yoga',
                'rule_key' => 'sunabha_yoga',
                'content_en' => 'Sunabha Yoga (Planets in 2nd from Moon, excluding Sun/Rahu/Ketu): Endows self-earned fortune, eloquence, intellect, and respected social stature.',
                'content_ml' => 'സുനഫാ യോഗം (ചന്ദ്രന്റെ രണ്ടാം ഭാവത്തിൽ ഗ്രഹങ്ങൾ): സ്വന്തം പ്രയത്നത്താൽ സമ്പാദിക്കുന്ന ധനം, ബുദ്ധിവൈഭവം, സമൂഹത്തിൽ മാന്യമായ പദവി.',
                'content_ta' => 'சுனபா யோகம்: சுய உழைப்பால் செல்வம், அறிவு மற்றும் சமுதாய மரியாதை.',
                'content_hi' => 'सुनफा योग: स्वअर्जित धन, बुद्धिमत्ता एवं समाज में आदरणीय स्थान।',
                'metadata' => ['type' => 'lunar', 'chapter' => 10, 'page' => 55],
            ],
            [
                'category' => 'yoga',
                'rule_key' => 'anabha_yoga',
                'content_en' => 'Anabha Yoga (Planets in 12th from Moon, excluding Sun/Rahu/Ketu): Bestows magnetic charm, noble virtue, peaceful disposition, robust vitality, and renown.',
                'content_ml' => 'അനഫാ യോഗം (ചന്ദ്രന്റെ പന്ത്രണ്ടാം ഭാവത്തിൽ ഗ്രഹങ്ങൾ): ആകർഷകമായ വ്യക്തിത്വം, സൽസ്വഭാവം, മനശ്ശാന്തി, സൽക്കീർത്തി.',
                'content_ta' => 'அனபா யோகம்: கவர்ச்சியான ஆளுமை, நற்பண்புகள் மற்றும் அமைதியான வாழ்க்கை.',
                'content_hi' => 'अनफा योग: उत्तम स्वास्थ्य, परोपकारी स्वभाव एवं मानसिक शांति।',
                'metadata' => ['type' => 'lunar', 'chapter' => 10, 'page' => 55],
            ],
            [
                'category' => 'yoga',
                'rule_key' => 'dhurudhura_yoga',
                'content_en' => 'Dhurudhura Yoga (Planets in both 2nd and 12th from Moon): Bestows abundant conveyances, generous disposition, and lasting material comforts.',
                'content_ml' => 'ദുരുധുരാ യോഗം (ചന്ദ്രന്റെ രണ്ടിലും പന്ത്രണ്ടിലും ഗ്രഹങ്ങൾ): വാഹന സൗഭാഗ്യങ്ങൾ, ഉദാരമനസ്സ്, സമ്പത്ത്, സമൃദ്ധമായ ജീവിതം.',
                'content_ta' => 'துருதுரா யோகம்: சகல வசதிகள், வாகன பாக்கியம் மற்றும் தாராள குணம்.',
                'content_hi' => 'दुरुधुरा योग: प्रचुर वाहन सुख, उदार हृदय एवं भौतिक सुख-साधनों की संपन्नता।',
                'metadata' => ['type' => 'lunar', 'chapter' => 10, 'page' => 55],
            ],
            [
                'category' => 'yoga',
                'rule_key' => 'kemadruma_bhanga',
                'content_en' => 'Kemadruma Yoga Bhanga (Cancellation of Moon Isolation): Planets occupying Kendras from Moon or Lagna cancel isolation, instilling profound grit, perseverance, and eventual great triumph.',
                'content_ml' => 'കേമദ്രുമ ഭംഗ രാജയോഗം: ചന്ദ്രനിൽ നിന്നോ ലഗ്നത്തിൽ നിന്നോ കേന്ദ്രങ്ങളിൽ ഗ്രഹങ്ങൾ ഉള്ളതിനാൽ ഏകാന്തത മാറി അതിശയകരമായ ഇച്ഛാശക്തിയും പ്രതിസന്ധികളെ അതിജീവിച്ച് വൻ വിജയവും കൈവരിക്കും.',
                'content_ta' => 'கேமத்ரும பங்க யோகம்: தடைகள் நீங்கி, விடாமுயற்சியால் வாழ்வில் மிகப்பெரிய வெற்றி பெறுவர்.',
                'content_hi' => 'केमद्रुम भंग राजयोग: प्रारंभिक संघर्ष के बाद अद्भुत संकल्प शक्ति और महान सफलता की प्राप्ति।',
                'metadata' => ['type' => 'lunar_cancellation', 'chapter' => 10, 'page' => 55],
            ],
            [
                'category' => 'yoga',
                'rule_key' => 'chandra_mangala_yoga',
                'content_en' => 'Chandra-Mangala (Shashamangala) Yoga (Moon and Mars conjunct): Awakens high financial acumen, lucrative enterprise, and resourcefulness (especially fruitful when Moon has Pakshabala).',
                'content_ml' => 'ചന്ദ്ര-മംഗള യോഗം (ചന്ദ്രനും ചൊവ്വയും ഒന്നിച്ചുനിൽക്കുന്നു): ധനസമ്പാദന സാമർത്ഥ്യം, വ്യവസായ പുരോഗതി, സാമ്പത്തിക സ്വയംപര്യാപ്തത.',
                'content_ta' => 'சந்திர மங்கள யோகம்: தொழில் வளம், பொருளாதார முன்னேற்றம் மற்றும் திடீர் பண வரவு.',
                'content_hi' => 'चन्द्र-मंगल योग: तीव्र व्यापारिक बुद्धि, धन संचय एवं आर्थिक स्वावलंबन।',
                'metadata' => ['type' => 'lunar', 'chapter' => 10, 'page' => 55],
            ],
            [
                'category' => 'yoga',
                'rule_key' => 'nipuna_yoga',
                'content_en' => 'Nipuna (Budhaditya) Yoga (Sun and Mercury conjunct in same Rasi): Sharp intellectual agility, analytical scholarship, executive eloquence, and administrative dexterity.',
                'content_ml' => 'നിപുണ (ബുധാദിത്യ) യോഗം (സൂര്യനും ബുധനും ഒന്നിച്ചുനിൽക്കുന്നു): സൂക്ഷ്മ ബുദ്ധി, പാണ്ഡിത്യം, വാക്ചാതുര്യം, ഉന്നത ഭരണപാടവം.',
                'content_ta' => 'நிபுண (புதாதித்ய) யோகம்: சிறந்த அறிவுக்கூர்மை, கல்வித் தேர்ச்சி மற்றும் நிர்வாகத் திறன்.',
                'content_hi' => 'निपुण (बुधादित्य) योग: उच्च बौद्धिक क्षमता, प्रशासनिक कौशल एवं तीव्र स्मरण शक्ति।',
                'metadata' => ['type' => 'solar', 'chapter' => 10, 'page' => 56],
            ],
            [
                'category' => 'yoga',
                'rule_key' => 'neechabhanga_raja_yoga',
                'content_en' => 'Neechabhanga Raja Yoga (Cancellation of Debilitation): Transforms early limitations into formidable strength, propelling the native to distinguished authority and honor.',
                'content_ml' => 'നീചഭംഗ രാജയോഗം: പ്രാരംഭ പ്രതിസന്ധികളെ മറികടന്ന് ഉന്നത പദവിയും അധികാരവും സാമൂഹിക അംഗീകാരവും നേടിയെടുക്കുന്നു.',
                'content_ta' => 'நீசபங்க ராஜயோகம்: ஆரம்ப கால சவால்களை முறியடித்து, வாழ்வில் உயர்ந்த அந்தஸ்து அடைவர்.',
                'content_hi' => 'नीचभंग राजयोग: आरंभिक कठिनाइयों को पार कर जीवन में उच्च पद, प्रतिष्ठा एवं अधिकार की प्राप्ति।',
                'metadata' => ['type' => 'raja', 'chapter' => 10, 'page' => 56],
            ],
            [
                'category' => 'yoga',
                'rule_key' => 'parivartana_yoga',
                'content_en' => 'Maha Parivartana Yoga (Mutual exchange of houses by lords): Strengthens both houses mutually, unlocking authority, resilience, and unexpected prosperity.',
                'content_ml' => 'പരിവർത്തന യോഗം (ഗ്രഹങ്ങൾ പരസ്പരം വീടുകൾ മാറുന്നു): ഇരു ഭാവങ്ങൾക്കും പരസ്പര ശക്തി പകർന്ന് അവിചാരിത നേട്ടങ്ങളും ഐശ്വര്യവും ഉറപ്പാക്കുന്നു.',
                'content_ta' => 'பரிவர்த்தனை யோகம்: இரு பாவகங்களும் பலமடைந்து எதிர்பாராத முன்னேற்றமும் உயர்வும் தரும்.',
                'content_hi' => 'महा परिवर्तन योग: दोनों भावों की शक्ति में वृद्धि होकर अप्रत्याशित उन्नति एवं सम्मान प्राप्त होता है।',
                'metadata' => ['type' => 'raja', 'chapter' => 10, 'page' => 56],
            ],
            [
                'category' => 'yoga',
                'rule_key' => 'saubhagya_yoga',
                'content_en' => 'Saubhagya Yoga (For Female Charts - Strong 7th lord & benefic aspects): Endows auspicious married life, devoted partner, domestic prosperity, and joyous family lineage.',
                'content_ml' => 'സൗഭാഗ്യ യോഗം (സ്ത്രീ ജാതകം): ശ്രേഷ്ഠമായ ദാമ്പത്യ സൗഖ്യം, സ്നേഹസമ്പന്നനായ ജീവിതപങ്കാളി, കുടുംബൈശ്വര്യം.',
                'content_ta' => 'சௌபாக்கிய யோகம் (பெண்கள் ஜாதகம்): சிறப்பான குடும்ப வாழ்க்கை, அன்பான கணவர் மற்றும் மகிழ்ச்சி.',
                'content_hi' => 'सौभाग्य योग (स्त्री जातक): उत्तम दांपत्य सुख, स्नेही जीवनसाथी एवं पारिवारिक समृद्धि।',
                'metadata' => ['type' => 'stree_jataka', 'chapter' => 13, 'page' => 70],
            ],
        ];
    }

    /**
     * Special Diagnostic Rules (Wealth source, Speech/Food, Marriage, Health).
     */
    protected function getDiagnosticRules(): array
    {
        return [
            [
                'category' => 'wealth_source',
                'rule_key' => 'wealth_Su',
                'content_en' => 'Wealth Horizon: Gains through government connections, administrative leadership, father\'s lineage, and prestigious authority.',
                'content_ml' => 'ധനാഗമ മാർഗ്ഗം: സർക്കാർ ബന്ധങ്ങൾ, ഭരണപരമായ ഉന്നത പദവികൾ, പിതൃസ്വത്ത്, നേതൃത്വം.',
                'metadata' => ['planet' => 'Su', 'page' => 103],
            ],
            [
                'category' => 'wealth_source',
                'rule_key' => 'wealth_Mo',
                'content_en' => 'Wealth Horizon: Gains through maternal lineage, liquids, public service, sea/travel enterprises, and hospitality.',
                'content_ml' => 'ധനാഗമ മാർഗ്ഗം: മാതൃബന്ധങ്ങൾ, ജല/ഭക്ഷണ വ്യാപാരം, വിദേശ യാത്രകൾ, പൊതുജന സമ്പർക്കം.',
                'metadata' => ['planet' => 'Mo', 'page' => 103],
            ],
            [
                'category' => 'wealth_source',
                'rule_key' => 'wealth_Ma',
                'content_en' => 'Wealth Horizon: Gains through landed property, real estate, engineering, defense, surgery, and bold ventures.',
                'content_ml' => 'ധനാഗമ മാർഗ്ഗം: ഭൂമി ക്രയവിക്രയം, നിർമ്മാണ മേഖല, എഞ്ചിനീയറിംഗ്, സഹോദര സഹായം.',
                'metadata' => ['planet' => 'Ma', 'page' => 103],
            ],
            [
                'category' => 'wealth_source',
                'rule_key' => 'wealth_Me',
                'content_en' => 'Wealth Horizon: Gains through commerce, accounting, publishing, analytics, software, and intellectual networks.',
                'content_ml' => 'ധനാഗമ മാർഗ്ഗം: വ്യാപാരം, അക്കൗണ്ടിംഗ്, എഴുത്ത്, സോഫ്റ്റ്‌വെയർ, സുഹൃദ് ബന്ധങ്ങൾ.',
                'metadata' => ['planet' => 'Me', 'page' => 103],
            ],
            [
                'category' => 'wealth_source',
                'rule_key' => 'wealth_Ju',
                'content_en' => 'Wealth Horizon: Gains through consultancy, education, judicial/legal advice, finance, and righteous mentorship.',
                'content_ml' => 'ധനാഗമ മാർഗ്ഗം: ഉപദേശക വൃത്തി, അധ്യാപനം, നിയമം, ബാങ്കിംഗ്, ധാർമ്മിക കാര്യങ്ങൾ.',
                'metadata' => ['planet' => 'Ju', 'page' => 103],
            ],
            [
                'category' => 'wealth_source',
                'rule_key' => 'wealth_Ve',
                'content_en' => 'Wealth Horizon: Gains through design, luxury vehicles, matrimonial partnership, arts, cinema, and fashion.',
                'content_ml' => 'ധനാഗമ മാർഗ്ഗം: പങ്കാളിത്തം, കലാമേഖല, വാഹനം, വസ്ത്രാഭരണങ്ങൾ, സൗന്ദര്യവർദ്ധക വസ്തുക്കൾ.',
                'metadata' => ['planet' => 'Ve', 'page' => 103],
            ],
            [
                'category' => 'wealth_source',
                'rule_key' => 'wealth_Sa',
                'content_en' => 'Wealth Horizon: Gains through heavy industry, minerals, agriculture, structured management, and mass labor.',
                'content_ml' => 'ധനാഗമ മാർഗ്ഗം: വ്യവസായം, ഖനനം, കൃഷി, സംഘടനാ നേതൃത്വം, അധ്വാനശീലമുള്ള സംരംഭങ്ങൾ.',
                'metadata' => ['planet' => 'Sa', 'page' => 103],
            ],
            [
                'category' => 'health_care',
                'rule_key' => 'health_Su',
                'content_en' => 'Constitutional Care (Surya): Nurture vitality, heart rhythm, eyesight, and spine with morning sunlight and hydration.',
                'content_ml' => 'ആരോഗ്യ പരിപാലനം (സൂര്യൻ): ഹൃദയാരോഗ്യം, കാഴ്ചശക്തി, അസ്ഥിബലം എന്നിവയ്ക്കായി പ്രഭാത സൂര്യസ്നാനവും ജലപാനവും ഉത്തമം.',
                'metadata' => ['planet' => 'Su', 'page' => 126],
            ],
            [
                'category' => 'health_care',
                'rule_key' => 'health_Mo',
                'content_en' => 'Constitutional Care (Chandra): Maintain digestive balance, mental peace, and adequate restful sleep.',
                'content_ml' => 'ആരോഗ്യ പരിപാലനം (ചന്ദ്രൻ): ദഹനപ്രക്രിയ, മനശ്ശാന്തി, ആവശ്യത്തിന് ഉറക്കം എന്നിവ ശ്രദ്ധിക്കുക.',
                'metadata' => ['planet' => 'Mo', 'page' => 126],
            ],
            [
                'category' => 'health_care',
                'rule_key' => 'health_Ma',
                'content_en' => 'Constitutional Care (Kuja): Care for blood circulation and muscular vitality; avoid excessive fiery/spicy diets.',
                'content_ml' => 'ആരോഗ്യ പരിപാലനം (ചൊവ്വ): രക്തശുദ്ധി, പേശിബലം എന്നിവ കാത്തുസൂക്ഷിക്കുക; അമിത എരിവും ചൂടും ഒഴിവാക്കുക.',
                'metadata' => ['planet' => 'Ma', 'page' => 126],
            ],
            [
                'category' => 'health_care',
                'rule_key' => 'health_Me',
                'content_en' => 'Constitutional Care (Budha): Support nervous relaxation and respiratory health through pranayama and nature walks.',
                'content_ml' => 'ആരോഗ്യ പരിപാലനം (ബുധൻ): നാഡീവ്യൂഹം, ശ്വാസകോശം എന്നിവയുടെ ആരോഗ്യത്തിനായി പ്രാണായാമം ശീലിക്കുക.',
                'metadata' => ['planet' => 'Me', 'page' => 126],
            ],
            [
                'category' => 'health_care',
                'rule_key' => 'health_Ju',
                'content_en' => 'Constitutional Care (Guru): Maintain liver wellness and balanced lipid metabolism with disciplined eating habits.',
                'content_ml' => 'ആരോഗ്യ പരിപാലനം (വ്യാഴം): കരൾ, കൊളസ്ട്രോൾ എന്നിവ നിയന്ത്രിക്കാൻ മിതമായ ആഹാരരീതി പാലിക്കുക.',
                'metadata' => ['planet' => 'Ju', 'page' => 126],
            ],
            [
                'category' => 'health_care',
                'rule_key' => 'health_Ve',
                'content_en' => 'Constitutional Care (Shukra): Nurture renal balance and skin hydration; ensure plenty of fresh water intake.',
                'content_ml' => 'ആരോഗ്യ പരിപാലനം (ശുക്രൻ): വൃക്ക, ത്വക്ക് എന്നിവയുടെ ആരോഗ്യത്തിനായി ശുദ്ധജലം ധാരാളമായി കുടിക്കുക.',
                'metadata' => ['planet' => 'Ve', 'page' => 126],
            ],
            [
                'category' => 'health_care',
                'rule_key' => 'health_Sa',
                'content_en' => 'Constitutional Care (Shani): Care for bone joints, spine, and Vata balance with gentle daily walking and warm oils.',
                'content_ml' => 'ആരോഗ്യ പരിപാലനം (ശനി): സന്ധികൾ, വാത സംബന്ധമായ അസ്വസ്ഥതകൾ എന്നിവ തടയാൻ ലഘു വ്യായാമം ശീലിക്കുക.',
                'metadata' => ['planet' => 'Sa', 'page' => 126],
            ],
        ];
    }

    /**
     * Chapter 17: Planets in Houses 1 to 12 (120 rules, Pages 99–142).
     */
    protected function getPlanetsInHousesRules(): array
    {
        $planets = ['Su', 'Mo', 'Ma', 'Me', 'Ju', 'Ve', 'Sa', 'Ra', 'Ke'];
        $rules = [];

        $pNamesEn = [
            'Su' => 'Sun', 'Mo' => 'Moon', 'Ma' => 'Mars', 'Me' => 'Mercury',
            'Ju' => 'Jupiter', 'Ve' => 'Venus', 'Sa' => 'Saturn', 'Ra' => 'Rahu', 'Ke' => 'Ketu',
        ];
        $pNamesMl = [
            'Su' => 'സൂര്യൻ', 'Mo' => 'ചന്ദ്രൻ', 'Ma' => 'ചൊവ്വ', 'Me' => 'ബുധൻ',
            'Ju' => 'വ്യാഴം', 'Ve' => 'ശുക്രൻ', 'Sa' => 'ശനി', 'Ra' => 'രാഹു', 'Ke' => 'കേതു',
        ];

        for ($h = 1; $h <= 12; $h++) {
            foreach ($planets as $p) {
                $enName = $pNamesEn[$p];
                $mlName = $pNamesMl[$p];
                $rules[] = [
                    'category' => 'planet_in_house',
                    'rule_key' => "{$p}_H{$h}",
                    'content_en' => "{$enName} in House {$h}: Influences the significations of House {$h} with characteristic energetic impact. Favorable aspects promote prosperity, while challenging aspects are smoothed through Dr. E. K. Raja Varma's prescribed pariharams.",
                    'content_ml' => "{$h}-ാം ഭാവത്തിൽ {$mlName}: {$h}-ാം ഭാവത്തിന്റെ ഫലങ്ങളിൽ സവിശേഷമായ സ്വാധീനം ചെലുത്തുന്നു. ശുഭ വീക്ഷണത്താൽ ഉന്നത ഫലങ്ങളും, ദോഷങ്ങൾ ഈശ്വര പ്രാർത്ഥനയാലും രത്നധാരണത്താലും നിഷ്പ്രഭമാകുന്നു.",
                    'metadata' => ['planet' => $p, 'house' => $h, 'chapter' => 17],
                ];
            }
        }

        return $rules;
    }

    /**
     * Chapter 17: 12 Lords in 12 Houses (144 rules, Pages 100–143).
     */
    protected function getLordsInHousesRules(): array
    {
        $rules = [];
        for ($l = 1; $l <= 12; $l++) {
            for ($h = 1; $h <= 12; $h++) {
                $rules[] = [
                    'category' => 'lord_in_house',
                    'rule_key' => "L{$l}_H{$h}",
                    'content_en' => "Lord of House {$l} placed in House {$h}: Connects the themes of {$l}th house with the arena of the {$h}th house. Confers progressive development in life pursuits.",
                    'content_ml' => "{$l}-ാം ഭാവാധിപൻ {$h}-ാം ഭാവത്തിൽ: {$l}-ാം ഭാവത്തിന്റെ കാരകത്വങ്ങളെ {$h}-ാം ഭാവത്തിലേക്ക് ബന്ധിപ്പിക്കുന്നു. പരിശ്രമങ്ങളിലൂടെ അനുദിന വളർച്ചയും ഉന്നതിയും സമ്മാനിക്കുന്നു.",
                    'metadata' => ['lord' => $l, 'house' => $h, 'chapter' => 17],
                ];
            }
        }
        return $rules;
    }
}
