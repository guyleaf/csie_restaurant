<?php
namespace App\Services;

use Illuminate\Support\Facades\Validator;
use App\Repositories\MemberRepository;
use InvalidArgumentException;
use Intervention\Image\Facades\Image as Image;

class MemberService
{
    /**
     * @var \App\Repositories\MemberRepository $memberRepository
     */
    protected $memberRepository;

    /**
     * Member service constructor
     *
     * @param \App\Repositories\MemberRepository $memberReposity
     */
    public function __construct(MemberRepository $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    /**
     * Validate basic arguments ex.currentNumber
     *
     * @param array $args
     * @return void
     */
    protected function validateBasicArgument($args)
    {
        $validator = Validator::make($args, [
            'currentNumber' => 'required|integer|min:0',
            'requiredNumber' => 'required|integer|min:0|max:50'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException(serialize($validator->errors()), 400);
        }
    }

    // protected function filterNull($data, $value)
    // {
    //     $data = $data->map(function ($item, $key) use ($value) {
    //         $item->numberofratings = $item->numberofratings == NULL ? $value : (double)$item->numberofratings;
    //         $item->averageofratings = $item->averageofratings == NULL ? $value : (double)$item->averageofratings;
    //         return $item;
    //     });

    //     return $data;
    // }

    public function getCustomers($numbers)
    {
        $this->validateBasicArgument($numbers);

        $currentNumber = (int)$numbers['currentNumber'];
        $requiredNumber = (int)$numbers['requiredNumber'];

        $result = $this->memberRepository
            ->getCustomers($currentNumber, $requiredNumber);

        return $result;
    }

    public function getSellers($numbers)
    {
        $this->validateBasicArgument($numbers);

        $currentNumber = (int)$numbers['currentNumber'];
        $requiredNumber = (int)$numbers['requiredNumber'];

        $result = $this->memberRepository
            ->getSellers($currentNumber, $requiredNumber);

        return $result;
    }

    public function updateMember($payload)
    {
        $this->memberRepository->updateMember($payload);
    }

    public function deleteMember($id)
    {
        $this->memberRepository->deleteMember($id);
    }

    /**
     * @param Illuminate\Http\UploadedFile $payload['seller']['header_image]
     */
    public function addMember($payload)
    {
        if($payload['member']['permission'] == 1)
        {
            if (!empty($payload['seller']['header_image']))
            {
                $image = Image::make($payload['seller']['header_image']->get())->resize(640, 480)->encode('jpg', 100);
                $payload['seller']['header_image'] = true;
            }
            else
                $payload['seller']['header_image'] = false;

            $member_id = $this->memberRepository->addSeller($payload);

            if (!file_exists('storage/restaurant/' . strval($member_id)))
                mkdir('storage/restaurant/' . strval($member_id), 0777);

            if (isset($image))
                $image->save('storage/restaurant/' . strval($member_id) . '/header.jpg');
        }
        elseif($payload['member']['permission'] == 2)
        {
            $this->memberRepository->addCustomer($payload);
        }
    }
}
?>
